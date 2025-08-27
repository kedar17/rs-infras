<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
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
        $tasks = Task::with(['project:id,name','user:id,name'])->paginate(15);
        //dd($tasks->first()->toArray());
        //$tasks = Task::with('client')->paginate(15);
        $projects  = Project::orderBy('name')->get();
        $users = User ::orderBy('Name')->get();
        return view('task', compact('tasks', 'projects','users'));
        //return view('tasks');
    }
    public function addTask(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'title'       => 'required|string|max:50',
            'project_id'  => 'required|exists:projects,id',
            'user_id'  => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|string',
            //'file'     => 'required|string|max:25',
            'descriptions'     => 'required|string|max:255',
        ]);
        dump($data); //die();
        // 2) Create the client, hashing the real password
        try {
            Task::create([
                'title'     => $data['title'],
                'project_id'    => $data['project_id'],
                'user_id'    => $data['user_id'],
                'start_date' => $data['start_date'],
                'end_date'     => $data['end_date'],
                'status'   => $data['status'],
                //'file'     => $data['file'],
                'descriptions'   => $data['descriptions'],
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        // 3) Redirect (adjust to your listing route)
        return redirect()
            ->route('task-management')  
            ->with('success', 'Task added successfully.');
    }
    // Handle “Update client”
    public function update(Request $request, Task $task)
    {
        
        $data = $request->validate([
            'title'       => 'required|string|max:50',
            'project_id'  => 'required|exists:projects,id',
            'user_id'  => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|string',
            //'file'     => 'required|string|max:25',
            'descriptions'     => 'required|string|max:255',
        ]);


        $task->update($data);

        return redirect()->route('task-management')->with('success', 'Task updated successfully.');
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('task-management')->with('success', 'Task deleted.');
    }
}
