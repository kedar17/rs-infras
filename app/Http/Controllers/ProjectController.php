<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;
use App\Models\Materials;
use App\Models\Expense;
use App\Models\Client;
use App\Models\User;
use App\Models\DailyWorkLog;

use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $projects = Project::with(['client:id,name','user:id,name'])->paginate(15);
        //dd($projects->first()->toArray());
        //$projects = Project::with('client')->paginate(15);
        $clients  = Client::orderBy('name')->get();
        $users = User ::orderBy('Name')->get();
        return view('projects', compact('projects', 'clients','users'));
        //return view('projects');
    }
    public function projectDetails($id){

        // Fetch tasks grouped by status
        $tasks = Task::where('project_id', $id)
            ->select('title', 'status','start_date','end_date')
            ->orderBy('status', 'DESC')
            ->get();
        
        $materials = Materials::with(['project:id,name', 'task:id,title'])
            ->where('project_id', $id)
            ->select('id','task_id','name','vendor','request_date','quantity','unit','status')
            ->get();

        $expenses = Expense::with(['project:id,name', 'category:id,name'])
            ->where('project_id', $id)
            ->select('id','category_id','amount','payment_mode','payment_ref','remarks','updated_at')
            ->get();
        $dailyWorkLogs = DailyWorkLog::with(['project:id,name','user:id,name'])
            ->where('project_id', $id)
            ->select('id','user_id','work_description','weather','work_summary','remarks','daily_log_photos','updated_at')
            ->get();
        $users = User ::orderBy('Name')->get();
        $project_id= $id;
        return view('project-details',compact('tasks','materials','expenses','users','project_id','dailyWorkLogs'));

    }
    public function addProject(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'budget'     => 'required|string|max:25',
            'status'     => 'required|string',
            'user_id'    => 'required|exists:users,id',
        ]);
        //dump($data);
        // 2) Create the client, hashing the real password
        try {
            Project::create([
                'client_id'     => $data['client_id'],
                'name'    => $data['name'],
                'start_date' => $data['start_date'],
                'end_date'     => $data['end_date'],
                'budget'   => $data['budget'],
                'status'   => $data['status'],
                'user_id'   => $data['user_id'],
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()
            ->route('projects')  
            ->with('success', 'project added successfully.');
    }
    public function addDailyWorkLog(Request $request)
    {
        // 1) Validate incoming data
        //dd($request);
        $data = $request->validate([
            'project_id' =>'required',
            'work_description'  => 'required',
            'user_id'       => 'required',
            'weather' => 'required',
            'work_summary'     => 'required|string|max:25',
            'remarks'     => 'required|string',
        ]);
        if ($request->hasFile('daily_log_photos')) {
            $file = $request->file('daily_log_photos');
            $filename =  'log_photo' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('work_assets/' . $filename);
            $file->move(public_path('work_assets'), $filename);

            $data['daily_log_photos'] = 'work_assets/' . $filename; // Save relative path
        }
        //dd($data);
        // 2) Create the client, hashing the real password
        try {
            DailyWorkLog::create($data);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return back()->with('success', 'project added successfully.');
    }
    // Handle “Update client”
    public function updateWorkLog(Request $request, DailyWorkLog $log)
    {
        //dd($request);
        $data = $request->validate([
            'project_id' =>'required',
            'work_description'  => 'required',
            'user_id'       => 'required',
            'weather' => 'required',
            'work_summary'     => 'required|string|max:25',
            'remarks'     => 'required|string',
        ]);
        if ($request->hasFile('daily_log_photos')) {
            $file = $request->file('daily_log_photos');
            $filename =  'log_photo' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('work_assets/' . $filename);
            $file->move(public_path('work_assets'), $filename);

            $data['daily_log_photos'] = 'work_assets/' . $filename; // Save relative path
        }
        //dd($data);
        $log->update($data);

        return back()->with('success', 'project added successfully.');
    }
     public function destroyWorkLog($id)
    {
        $log = DailyWorkLog::findOrFail($id);
        $log->delete();
        return back()->with('success', 'project added successfully.');
    }
    public function update(Request $request, Project $project)
    {
        
        $data = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'budget'     => 'required|string|max:25',
            'status'     => 'required|string',
            'user_id'    => 'required|exists:users,id',
        ]);


        $project->update($data);

        return redirect()->route('projects')->with('success', 'Project updated successfully.');
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('projects')->with('success', 'Project deleted.');
    }
   
}
