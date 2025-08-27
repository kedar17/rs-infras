<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Contact;

class PaymentSettlementComtroller extends Controller
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
    /**
     * Display a blank table by default, or budget for the selected project.
     */
    public function index()
    {
        $settlements = Settlement::with(['project:id,name', 'user:id,name','contact:id,name'])->paginate(15);
        $projects  = Project::orderBy('name')->get();
        $users  = User::orderBy('name')->get();
        $contacts  = Contact::orderBy('name')->get();
        return view('payment-settlement', compact('settlements', 'projects','contacts','users'));
    }

    public function addSettlement(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'settled_by'       => 'required',
            'contact_id'          => 'required|exists:clients,id',
            'date'  => 'required|date',
            'amount'          => 'required',
            'mode'          => 'required',
            'reference_no'          => 'required|string|max:25',
            'status'        => 'required|string',

        ]);
        //dd($data); //die();
        // 2) Create the client, hashing the real password
        try {
            Settlement::create([

                'project_id'    => $data['project_id'],
                'settled_by'    => $data['settled_by'],
                'contact_id'    => $data['contact_id'],
                'amount'    => $data['amount'],
                'mode'    => $data['mode'],
                'reference_no'     => $data['reference_no'],
                'date'     => $data['date'],
                'status'     => $data['status'],

            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()->route('payment-settlement')->with('success', 'budget added successfully.');
    }
    // Handle “Update Budget
    public function update(Request $request, Settlement $settlement)
    {
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'settled_by'       => 'required',
            'contact_id'          => 'required|exists:clients,id',
            'date'  => 'required|date',
            'amount'          => 'required',
            'mode'          => 'required',
            'reference_no'          => 'required|string|max:25',
            'status'        => 'required|string',
        ]);

        $settlement->fill($data);

        if (!$settlement->isDirty()) {
            return back()->with('info', 'No changes detected.');
        }

        try {
            DB::enableQueryLog(); // Optional: for debugging
            $settlement->save();
            Log::info('budget updated SQL', DB::getQueryLog()); // Write queries to log
        } catch (\Exception $e) {
            Log::error('budget update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update Payment Log.');
        }

        return redirect()->route('payment-settlement')->with('success', 'Payment log updated successfully.');
    }

    public function destroy($id)
    {
        $budget = Settlement::findOrFail($id);
        $budget->delete();
        return redirect()->route('payment-settlement')->with('success', 'budget deleted.');
    }
    //filter budget
    public function filtersettlement(Request $request)
    {
        $projectId = $request->query('settlement_id');

        // Validate project_id
        if (! $projectId || ! is_numeric($projectId)) {
            return response()->json([
                'success' => false,
                'html'    => '<tr><td colspan="10" class="text-center text-danger">Invalid project selected.</td></tr>'
            ], 422);
        }

        // Fetch budget with relationships
        $settlement = Settlement::with(['project:id,name', 'user:id,name','contact:id,name'])
            ->where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->get();

        // Render the partial into a string
        $html = view('partials.ajax-settlement-rows', [
            'settlements' => $settlement,
            'projectId' => $projectId
        ])->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }
}
