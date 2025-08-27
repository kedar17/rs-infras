<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::orderBy('date','desc')->paginate(10);
        return view('proposals.index', compact('proposals'));
    }

    // SHOW: display a single proposal
    public function show(Proposal $proposal)
    {
        // decode JSON columns for easier consumption in Blade
        $proposal->items = json_decode($proposal->items, true);

        return view('proposals.show', compact('proposal'));
    }
    public function edit(Proposal $proposal)
    {
        return view('proposals.edit', compact('proposal'));
    }

    // CREATE: show blank form
    public function create()
    {
        return view('proposals.create');
    }

    // STORE: validate & persist new proposal
   public function addProposal(Request $request)
{
    $data = $request->validate([
        'date'               => 'required|date',
        'reference'          => 'required|string|max:255',
        'client_name'        => 'required|string|max:255',
        'client_address'     => 'required|string',
        'client_mobile'      => 'required|string|max:50',
        'subject'            => 'required|string|max:255',
        'body_intro'         => 'required|string',
        'items'              => 'required|array|min:1',
        'items.*.description'=> 'required|string',
        'items.*.qty'        => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'price_total'        => 'required|numeric|min:0',
        'price_gst_percent'  => 'required|integer|min:0|max:100',
        'price_in_words'     => 'required|string|max:255',
        'scope_of_work'      => 'required|string', // Changed from array to string
        'warranty'           => 'required|string', // Changed from array to string
        'payment_schedule'   => 'required|string', // Changed from array to string
        'notes'              => 'nullable|string', // Changed from array to string
        'signatory_name'     => 'required|string|max:255',
        'signatory_role'     => 'required|string|max:255',
    ]);

    // Convert only the items array to JSON
    $data['items'] = json_encode($data['items']);
    
    // The other fields (scope_of_work, warranty, payment_schedule, notes) 
    // are now HTML strings from the rich text editors, so they don't need conversion

    try {
        Proposal::create($data);
    } catch (\Exception $e) {
        // It's better to log the error and show a user-friendly message
        //Log::error('Proposal creation failed: ' . $e->getMessage());
        
        return back()
            ->withInput()
            ->with('error', 'Failed to create proposal. Please try again.');
    }

    return redirect()
        ->route('proposals')
        ->with('success', 'Proposal created successfully.');
}
    public function update(Request $request, Proposal $proposal)
    {
        
        $data = $request->validate([
        'date'               => 'required|date',
        'reference'          => 'required|string|max:255',
        'client_name'        => 'required|string|max:255',
        'client_address'     => 'required|string',
        'client_mobile'      => 'required|string|max:50',
        'subject'            => 'required|string|max:255',
        'body_intro'         => 'required|string',
        'items'              => 'required|array|min:1',
        'items.*.description'=> 'required|string',
        'items.*.qty'        => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'price_total'        => 'required|numeric|min:0',
        'price_gst_percent'  => 'required|integer|min:0|max:100',
        'price_in_words'     => 'required|string|max:255',
        'scope_of_work'      => 'required|string', // Changed from array to string
        'warranty'           => 'required|string', // Changed from array to string
        'payment_schedule'   => 'required|string', // Changed from array to string
        'notes'              => 'nullable|string', // Changed from array to string
        'signatory_name'     => 'required|string|max:255',
        'signatory_role'     => 'required|string|max:255',
    ]);

    // Convert only the items array to JSON
    $data['items'] = json_encode($data['items']);
        //dd($data);
        try {
            $proposal->update($data);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
       

        return redirect()->route('proposals')->with('success', 'Proposal updated successfully.');
    }
    public function download(Proposal $proposal)
    {
        $pdf = PDF::loadView('proposals.pdf', compact('proposal'))
                ->setPaper('a4', 'portrait');
        return $pdf->download("proposal-{$proposal->client_name}.pdf");
    }
     public function destroy($id)
    {
        $task = Proposal::findOrFail($id);
        $task->delete();
        return redirect()->route('task-management')->with('success', 'Task deleted.');
    }
}