<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ContactController extends Controller
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
        $contacts = Contact::all();
        return view('contact', compact('contacts'));
        //return view('contacts');
    }
    public function addcontact(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:10',
            'email'    => 'required|email|unique:contacts,email',
            'phone' => 'required|string|min:10',
            'address'     => 'required|string|max:255',
            'status'   => 'required|in:0,1',
        ]);

        // 2) Create the contact, hashing the real password
        Contact::create([
            'name'     => $data['name'],
            'type'    => $data['type'],
            'email'    => $data['email'],
            'phone' => $data['phone'],
            'address'     => $data['address'],
            'status'   => $data['status'],
        ]);

        // 3) Redirect (adjust to your listing route)
        return redirect()
            ->route('contacts')  
            ->with('success', 'contact added successfully.');
            //return redirect()->route('contacts'); 
    }
    // Handle “Update contact”
    public function update(Request $request, Contact $contact)
    {
        
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:10',
            'email'    => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|min:10',
            'address'     => 'required|string | max:255',
            'status'   => 'required|in:0,1',
        ]);

        //dd($data);
        $contact->update($data);

        return redirect()->route('contacts')->with('success', 'contact updated successfully.');
    }
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts')->with('success', 'contact deleted.');
    }
    

}
