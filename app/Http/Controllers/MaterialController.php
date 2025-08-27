<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Materials;
use App\Models\Project;
use App\Models\Task;

class MaterialController extends Controller
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
     * Display a blank table by default, or materials for the selected project.
     */
    public function index()
    {
        $materials = Materials::with(['project:id,name', 'task:id,title'])->paginate(15);
        $projects  = Project::orderBy('name')->get();
        $tasks  = Task::orderBy('title')->get();
        return view('materials', compact('materials', 'projects', 'tasks'));
    }
    public function filterMaterial(Request $request)
{
    $projectId = $request->query('project_id');

    // Validate project_id
    if (! $projectId || ! is_numeric($projectId)) {
        return response()->json([
            'success' => false,
            'html'    => '<tr><td colspan="10" class="text-center text-danger">Invalid project selected.</td></tr>'
        ], 422);
    }

    // Fetch materials with relationships
    $materials = Materials::with(['project:id,name', 'task:id,title'])
        ->where('project_id', $projectId)
        ->orderBy('id', 'desc')
        ->get();

    // Render the partial into a string
    $html = view('partials.ajax-material-rows', [
        'materials' => $materials,
        'projectId' => $projectId
    ])->render();

    return response()->json([
        'success' => true,
        'html'    => $html
    ]);
}

    
    public function addmaterials(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'task_id'     =>  'required|exists:tasks,id',
            'name'       => 'required|string|max:50',
            'quantity'  => 'required|numeric',
            'unit'  => 'required|string',
            'unit_cost'  => 'required|numeric',
            'vendor'  => 'required|string',
            'request_date' => 'required|date',
            'status'     => 'required|string',

        ]);
        dump($data); //die();
        // 2) Create the client, hashing the real password
        try {
            Materials::create([

                'project_id'    => $data['project_id'],
                'task_id'    => $data['task_id'],
                'name'     => $data['name'],
                'quantity'     => $data['quantity'],
                'unit'     => $data['unit'],
                'unit_cost'     => $data['unit_cost'],
                'name'     => $data['name'],
                'vendor'    => $data['vendor'],
                'request_date' => $data['request_date'],
                'status'     => $data['status'],

            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()->route('materials')->with('success', 'Materials added successfully.');
    }
    // Handle “Update client”

    public function update1(Request $request, Materials $materials)
    {
        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'task_id'     =>  'required|exists:tasks,id',
            'name'       => 'required|string|max:50',
            'quantity'  => 'required|numeric',
            'unit'  => 'required|string',
            'unit_cost'  => 'required|numeric',
            'vendor'  => 'required|string',
            'request_date' => 'required|date',
            'status'     => 'required|string',
        ]);
        $materials->update($data);
        return redirect()
            ->route('materials')        // adjust to your route name
            ->with('success', 'Material updated successfully.');
    }
    public function update(Request $request, Materials $material)
    {
        $data = $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'task_id'       => 'required|exists:tasks,id',
            'name'          => 'required|string|max:50',
            'quantity'      => 'required|numeric',
            'unit'          => 'required|string',
            'unit_cost'     => 'required|numeric',
            'vendor'        => 'required|string',
            'request_date'  => 'required|date',
            'status'        => 'required|string',
        ]);

        $material->fill($data);

        if (! $material->isDirty()) {
            return back()->with('info', 'No changes detected.');
        }

        try {
            DB::enableQueryLog(); // Optional: for debugging
            $material->save();
            Log::info('Material updated SQL', DB::getQueryLog()); // Write queries to log
        } catch (\Exception $e) {
            Log::error('Material update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update material.');
        }

        return redirect()->route('materials')->with('success', 'Material updated successfully.');
    }

    public function destroy($id)
    {
        $materials = Materials::findOrFail($id);
        $materials->delete();
        return redirect()->route('materials')->with('success', 'materials deleted.');
    }
}
