<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
        //return view('users');
    }
    public function addUser(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:Admin,Contractor,Client,Engineer',
            'status'   => 'required|in:0,1',
        ]);

        // 2) Create the user, hashing the real password
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'status'   => $data['status'],
        ]);

        // 3) Redirect (adjust to your listing route)
        return redirect()
            ->route('users')  
            ->with('success', 'User added successfully.');
            //return redirect()->route('users'); 
    }
    // Handle “Update User”
    public function update(Request $request, User $user)
    {
        
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|string|max:55',
            'status'   => 'required|in:0,1',
        ]);

        // Only hash & overwrite password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        //echo '<pre>';print_r($data); die();
        $user->fill($data);

        if (!$user->isDirty()) {
            return back()->with('info', 'No changes detected.');
        }

        try {
            DB::enableQueryLog(); // Optional: for debugging
            $user->save();
            Log::info('budget updated SQL', DB::getQueryLog()); // Write queries to log
        } catch (\Exception $e) {
            Log::error('budget update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update budget.');
        }
        //$user->update($data);

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'User deleted.');
    }
    // Handles the logout action
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate and regenerate to clear session & CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login screen (or home)
        return redirect()->route('login');
    }

}
