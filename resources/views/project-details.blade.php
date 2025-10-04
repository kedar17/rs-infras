@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Task Timeline Tracking -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Task Timeline</b></h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th>Timeline (Days)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $index => $task)
                           
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{$task->title}}</td>
                                <td>{{$task->start_date}}</td>
                                <td>{{$task->end_date}}</td>
                                <td>
                                    <span class="badge {{$task->status == 'Completed'? 'bg-success': 'bg-danger';}}">
                                        {{$task->status}}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $startDate = new DateTime($task->start_date);
                                        $endDate   = new DateTime($task->end_date);
                                        $currentDate = new DateTime('now', new DateTimeZone('Asia/Kolkata'))->format('Y-m-d');
                                      
                                   
                                        // Difference object
                                        //$remaining = $currentDate->diff($endDate);

                                        $diff = $startDate->diff($endDate);
                                        //$daysLeft = $remaining->days;
                                        // Exclusive of end date
                                        $totalDaysExclusive = $diff->days;           // 16

                                        // Inclusive of end date
                                        $totalDaysInclusive = $diff->days + 1;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar bar-completed" style="width: 100%">{{$totalDaysInclusive}} Days
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Material Tracking -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Material Tracking</b></h1>

        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Material</th>
                                <th>Task</th>
                                <th>Requested</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $index => $material)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{ $material->name }} ({{ $material->quantity }} - {{$material->unit}})</td>
                                <td> {{ optional($material->task)->title ?? '— No Task —' }}</td>
                                <td>{{ $material->request_date ?? '—' }}</td>
                                <td>{{ $material->status ?? '—' }}</td>

                                <!-- <td>
                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td> -->
                            </tr>
                            @endforeach
                            <!-- More material rows -->
                        </tbody>
                    </table>
                </div>
            </div>

            


        <!-- Expenditure  Tracking -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Expenditure & Budget Tracking</b></h1>
            <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#addExpenseModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Add Expense
            </a> -->
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Payment Reference</th>
                                <th>Remarks</th>
                                
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $index => $expense)
                        <tr>
                           
                            <td>{{ ++$index }}</td>
                            <td>{{ $expense->updated_at ?? '—' }}</td>
                            <td>{{ $expense->category->name }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->payment_mode }}</td>
                            <td>{{ $expense->payment_ref }}</td>
                            <td>{{ $expense->remarks }}</td>
                            
                            <!-- <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editexpenseModal-{{ $expense->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $expense->id }}">
                                    Delete
                                </button>
                            </td> -->
                        </tr>
                        @endforeach
                            <!-- More rows dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Daily Work Log  Tracking -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Daily Work Log</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#logEntryModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Add Work Log
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Area of Work</th>
                                <th>Logged By</th>
                                <th>Work Summary</th>
                                <th>Weather</th>
                                <th>Photos</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($dailyWorkLogs as $index => $dailyWorkLog)
                        <tr>
                           
                            <td>{{ ++$index }}</td>
                            <td>{{ $dailyWorkLog->updated_at ?? '—'}}</td>
                            <td>{{ $dailyWorkLog->work_description ?? '—' }}</td>
                            <td>{{ $dailyWorkLog->user->name ?? '-' }}</td>
                            <td>{{ $dailyWorkLog->work_summary }}</td>
                            <td>{{ $dailyWorkLog->weather }}</td>
                            <td>@if (!empty($dailyWorkLog->daily_log_photos))
                                <a href="{{ url($dailyWorkLog->daily_log_photos) }}" class="btn btn-sm btn-outline-primary" target="_blank"
                                > View</a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary"disabled > View </button>
                                @endif
                            </td>
                            <td>{{ $dailyWorkLog->remarks }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $dailyWorkLog->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#alertModal-{{ $dailyWorkLog->id }}">Delete
                                </button>
                                </td>
                            </tr>
                            @endforeach
                            <!-- More entries -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="logEntryModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" id="addDailyWorkLog" method="POST" action="{{ route('add-work-log') }}"  enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="project_id" value="{{$project_id}}" />
                        <div class="modal-header">
                            <h5 class="modal-title">New Work Log Entry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3 px-4">
                            <div class="col-md-6">
                                <label>Project Area</label>
                                <input type="text" class="form-control" name="work_description"
                                    placeholder="e.g., Foundation, Roofing" required>
                            </div>
                            <div class="col-md-6">
                                <label>Assigned To</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">--- Select A User ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label>Weather</label>
                                <select class="form-select" name="weather">
                                    <option>Sunny</option>
                                    <option>Cloudy</option>
                                    <option>Rainy</option>
                                    <option>Stormy</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Upload Photos (optional)</label>
                                <input
                                    type="file"
                                    id="daily_log_photos"
                                    name="daily_log_photos"
                                    class="form-control-file"
                                    multiple
                                    required
                                >
                            </div>
                            <div class="col-12">
                                <label>Work Summary</label>
                                <textarea class="form-control" rows="3" name="work_summary"
                                    placeholder="Brief of work completed by today" required></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label>Remarks / Issues</label>
                                <textarea class="form-control" rows="2" name="remarks"
                                    placeholder="Any notes or problems on site"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-dark">Save Work Log</button>
                        </div>
                    </form>
                </div>
            </div>
             @foreach($dailyWorkLogs as $dailyWorkLog)
            <div class="modal fade" id="editModal-{{ $dailyWorkLog->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" id="editTaskForm" method="POST" action="{{ route('work_log.update', $dailyWorkLog->id) }}">
                        @csrf
                        @method('PUT')
                         <input type="hidden" name="project_id" value="{{$project_id}}" />
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3 px-4">
                            <div class="col-md-6">
                                <label>Project Area</label>
                                <input type="text" class="form-control" name="work_description" value="{{ old('work_description', $dailyWorkLog->work_description ?? '') }}"
                                    placeholder="e.g., Foundation, Roofing" required>
                            </div>
                            <div class="col-md-6">
                                <label>Assigned To</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">--- Select A User ---</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $dailyWorkLog->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                    </option>
                                
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label>Weather</label>
                                <select class="form-select" name="weather">
                                    <option {{ $dailyWorkLog->weather == 'Sunny' ? 'selected':'' }}>Sunny</option>
                                    <option {{ $dailyWorkLog->weather == 'Cloudy' ? 'selected':'' }}>Cloudy</option>
                                    <option {{ $dailyWorkLog->weather == 'Rainy' ? 'selected':'' }}>Rainy</option>
                                    <option {{ $dailyWorkLog->weather == 'Stormy' ? 'selected':'' }}>Stormy</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Upload Photos (optional)</label>
                                <input type="file" id="daily_log_photos" name="daily_log_photos" class="form-control-file" multiple>
                            </div>
                            <div class="col-12">
                                <label>Work Summary</label>
                                <textarea class="form-control" rows="3" name="work_summary"
                                    placeholder="Brief of work completed by today" >{{ old('work_summary', $dailyWorkLog->work_summary ?? '') }}
                                </textarea>
                            </div>
                            
                            <div class="col-12">
                                <label>Remarks / Issues</label>
                                <textarea class="form-control" rows="2" name="remarks"
                                    placeholder="Any notes or problems on site">{{ old('remarks', $dailyWorkLog->remarks ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-dark">Save Work Log</button>
                        </div>
                    
                    </form>
                </div>
            </div>
            @include('partials.alertModal', [
                'dataDetails' => $dailyWorkLog,
                'table'=>'daily_work_logs'
                ]
                )
        @endforeach
        <!--- End Edit modal --->
        </div>
    </div>
    @endsection