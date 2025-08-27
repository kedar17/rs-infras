<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\Project;
use App\Models\Category;

class ExpenseTrackController extends Controller
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
        $expenses = Expense::with(['project:id,name', 'category:id,name'])->paginate(15);
        $projects  = Project::orderBy('name')->get();
        $categories  = Category::orderBy('name')->get();
        return view('expense-track', compact('expenses', 'projects', 'categories'));
    }
    public function addExpense(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'category_id'       => 'required|exists:categories,id',
            'amount'          => 'required|string|max:50',
            'payment_mode'  => 'required|string|max:50',
            'payment_ref'  => 'required|string|max:50',
            'remarks'          => 'required|string|max:255',

        ]);
        dump($data); //die();
        // 2) Create the client, hashing the real password
        try {
            Expense::create([

                'project_id'    => $data['project_id'],
                'category_id'    => $data['category_id'],
                'amount'     => $data['amount'],
                'payment_mode'     => $data['payment_mode'],
                'payment_ref'     => $data['payment_ref'],
                'remarks'     => $data['remarks'],
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()->route('expense-track')->with('success', 'expense added successfully.');
    }
    // Handle “Update expense
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'category_id'       => 'required|exists:categories,id',
            'amount'          => 'required|string|max:50',
            'payment_mode'  => 'required|string|max:50',
            'payment_ref'  => 'required|string|max:50',
            'remarks'          => 'required|string|max:255',
        ]);

        $expense->fill($data);

        if (! $expense->isDirty()) {
            return back()->with('info', 'No changes detected.');
        }

        try {
            DB::enableQueryLog(); // Optional: for debugging
            $expense->save();
            Log::info('expense updated SQL', DB::getQueryLog()); // Write queries to log
        } catch (\Exception $e) {
            Log::error('expense update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update expense.');
        }

        return redirect()->route('expense-track')->with('success', 'expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('expense-track')->with('success', 'expense deleted.');
    }
    //filter expense
    public function filterExpense(Request $request)
    {
        $projectId = $request->query('expense_id');

        // Validate project_id
        if (! $projectId || ! is_numeric($projectId)) {
            return response()->json([
                'success' => false,
                'html'    => '<tr><td colspan="10" class="text-center text-danger">Invalid project selected.</td></tr>'
            ], 422);
        }

        // Fetch expense with relationships
        $expense = Expense::with(['project:id,name','category:id,name'])
            ->where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->get();

        // Render the partial into a string
        $html = view('partials.ajax-expense-rows', [
            'expenses' => $expense,
            'projectId' => $projectId
        ])->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }
}


