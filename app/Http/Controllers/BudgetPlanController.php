<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Project;
use App\Models\Category;

class BudgetPlanController extends Controller
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
        $budgets = Budget::with(['project:id,name', 'category:id,name'])->paginate(15);
        $projects  = Project::orderBy('name')->get();
        $categories  = Category::orderBy('name')->get();
        return view('budget-plan', compact('budgets', 'projects', 'categories'));
    }

    public function addBudget(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'category_id'       => 'required|exists:categories,id',
            'est_cost'          => 'required|string|max:50',
            'date'  => 'required|date',
            'remarks'          => 'required|string|max:255',
            'status'        => 'required|string',

        ]);
        dump($data); //die();
        // 2) Create the client, hashing the real password
        try {
            Budget::create([

                'project_id'    => $data['project_id'],
                'category_id'    => $data['category_id'],
                'est_cost'     => $data['est_cost'],
                'date'     => $data['date'],
                'remarks'     => $data['remarks'],
                'status'     => $data['status'],

            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()->route('budget-planning')->with('success', 'budget added successfully.');
    }
    // Handle “Update Budget
    public function update(Request $request, Budget $budget)
    {
        $data = $request->validate([
            'project_id'        => 'required|exists:projects,id',
            'category_id'       => 'required|exists:categories,id',
            'est_cost'          => 'required|string|max:50',
            'date'              => 'required|date',
            'remarks'           => 'required|string|max:255',
            'status'            => 'required|string',
        ]);

        $budget->fill($data);

        if (!$budget->isDirty()) {
            return back()->with('info', 'No changes detected.');
        }

        try {
            DB::enableQueryLog(); // Optional: for debugging
            $budget->save();
            Log::info('budget updated SQL', DB::getQueryLog()); // Write queries to log
        } catch (\Exception $e) {
            Log::error('budget update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update budget.');
        }

        return redirect()->route('budget-planning')->with('success', 'budget updated successfully.');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        return redirect()->route('budget-planning')->with('success', 'budget deleted.');
    }
    //filter budget
    public function filterBudget(Request $request)
    {
        $projectId = $request->query('budget_id');

        // Validate project_id
        if (! $projectId || ! is_numeric($projectId)) {
            return response()->json([
                'success' => false,
                'html'    => '<tr><td colspan="10" class="text-center text-danger">Invalid project selected.</td></tr>'
            ], 422);
        }

        // Fetch budget with relationships
        $budget = Budget::with(['project:id,name','category:id,name'])
            ->where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->get();

        // Render the partial into a string
        $html = view('partials.ajax-budget-rows', [
            'budgets' => $budget,
            'projectId' => $projectId
        ])->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }
}
