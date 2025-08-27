<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Models\Task;
use App\Models\Budget;      // or Payment model
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $projects            = Project::orderBy('name')->get();
        $projectsCount       = Project::count();
        $usersCount          = User::count();
        $clientsCount        = Client::count();
        $totalTasks          = Task::count();
        $completedTaskCount  = Task::completed()->count();
        $completedTaskPercent = $totalTasks > 0
            ? round(($completedTaskCount / $totalTasks) * 100, 2)
            : 0;

        $now = Carbon::now();

        // 1. Fetch all completed tasks this year with their project
        $tasksThisYear = Task::completed()
            ->with('project')
            ->whereYear('end_date', $now->year)
            ->get();

        // 2. Initialize zero-filled counts and empty project lists
        $monthlyCompleted = array_fill(1, 12, 0);
        $monthlyProjects  = array_fill(1, 12, []);

        // 3. Populate counts and project names
        foreach ($tasksThisYear as $task) {
            $date  = Carbon::parse($task->end_date);
            $month = $date->month;
            //$month = (int) $task->end_date->format('n');  // 1–12
            $monthlyCompleted[$month]++;

            // Collect project name (avoid duplicates with array_unique later)
            $monthlyProjects[$month][] = $task->project->name;
        }

        // 4. Optionally dedupe project names per month
        foreach ($monthlyProjects as $m => $names) {
            $monthlyProjects[$m] = array_values(array_unique($names));
        }

        return view('dashboard', compact(
            'projects',
            'projectsCount',
            'clientsCount',
            'usersCount',
            'completedTaskPercent',
            'monthlyCompleted',
            'monthlyProjects'
        ));
    }

    public function filterTasks(Request $request)
    {
        $projectId = $request->input('project_id');

        // Fetch tasks grouped by status
        $tasksByStatus = Task::where('project_id', $projectId)
            ->select('title', 'status')
            ->get()
            ->groupBy('status');

        // Prepare counts and title lists
        $completedGroup   = $tasksByStatus->get('Completed', collect());
        $inProgressGroup  = $tasksByStatus->get('In Progress', collect());

        $completed         = $completedGroup->count();
        $inProgress        = $inProgressGroup->count();
        $total             = $completed + $inProgress;

        $completedPercent  = $total ? round($completed    / $total * 100, 2) : 0;
        $inProgressPercent = $total ? round($inProgress   / $total * 100, 2) : 0;

        $completedTitles   = $completedGroup->pluck('title')->all();
        $inProgressTitles  = $inProgressGroup->pluck('title')->all();

        return response()->json([
            'completed'          => $completed,
            'completedPercent'   => $completedPercent,
            'completedTitles'    => $completedTitles,
            'inProgress'         => $inProgress,
            'inProgressPercent'  => $inProgressPercent,
            'inProgressTitles'   => $inProgressTitles,
        ]);
    }
}
