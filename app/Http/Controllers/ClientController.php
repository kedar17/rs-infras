<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ClientController extends Controller
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
        $clients = Client::all();
        return view('clients', compact('clients'));
        //return view('clients');
    }
    public function addclient(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:clients,email',
            'phone' => 'required|string|min:10',
            'address'     => 'required|string|max:255',
            'status'   => 'required|in:0,1',
        ]);

        // 2) Create the client, hashing the real password
        Client::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone' => $data['phone'],
            'address'     => $data['address'],
            'status'   => $data['status'],
        ]);

        // 3) Redirect (adjust to your listing route)
        return redirect()
            ->route('clients')  
            ->with('success', 'client added successfully.');
            //return redirect()->route('clients'); 
    }
    // Handle “Update client”
    public function update(Request $request, Client $client)
    {
        
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|min:8',
            'address'     => 'required|string | max:255',
            'status'   => 'required|in:0,1',
        ]);


        $client->update($data);

        return redirect()->route('clients')->with('success', 'client updated successfully.');
    }
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients')->with('success', 'client deleted.');
    }
    

}
