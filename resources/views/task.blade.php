@extends('layouts.app')
@section('content')
<div class="container-fluid">
     @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if (session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Task Management-->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Task Management</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addTaskModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Task
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <table class="table table-bordered text-center align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Task</th>
                            <th>Descriptions</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Start - End</th>
                            <!-- <th>Linked Docs</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td> {{ $task->project->name ?? '—' }}</td>
                            <td>{{ $task->title }} </td>
                            <td> {{ $task->descriptions ?? '—' }}</td>
                            <td>{{ $task->user->name ?? '—' }}</td>
                            <td><span class="badge bg-success">{{ $task->status }}</span></td>
                           @php
                                $endDate = DateTime::createFromFormat('Y-m-d', $task->end_date );
                                $startDate = DateTime::createFromFormat('Y-m-d', $task->start_date );
                            @endphp
                            <td>{{ $startDate->format('d F') }} - {{$endDate->format('d F') }}</td>
                            
                            
                            <td>
                                <a href="projects-details.php" class="btn btn-sm btn-secondary">View</a>
                                <button class="btn btn-sm btn-warning" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editTaskModal-{{ $task->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#alertModal-{{ $task->id }}">Delete
                                </button>
                               
                            </td>
                        </tr>
                        @endforeach
                       
                        <!-- More tasks -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Milestone Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="addTaskForm" method="POST" action="{{ route('add-task') }}">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Task Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label>Project</label>
                            <select class="form-select" name="project_id"required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">
                                    {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Assigned To</label>
                            <select class="form-select" name="user_id"required>
                                
                                <option selected disabled>--- Select Team --- </option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date"  name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" name="end_date"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status"> 
                                <option>Planned</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                                <option>Delayed</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-6">
                            <label>Upload Related Files</label>
                            <input type="file" name="files" class="form-control" multiple>
                        </div> -->
                        <div class="col-md-12">
                            <label>Remarks / Description</label>
                            <textarea name="descriptions"class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Project Modal -->
        @foreach($tasks as $task)
            <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" id="editTaskForm" method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label>Task Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('ttitle', $task->title ?? '') }}" required />
                            </div>
                            <div class="col-md-6">
                                <label>Project</label>
                                <select name="project_id" id="project_id" class="form-control" required>
                                    <option value="">--- Select A Project ---</option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ $project->id == $task->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                    </option>
                                
                                    @endforeach
                                </select>
                            
                            </div>
                            <div class="col-md-6">
                                <label>Assigned To</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">--- Select A User ---</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected':'' }}> 
                                        {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select class="form-select" name="status">
                                    <option value="Planned" {{ $task->status == 'Planned' ? 'selected':'' }}>Planned</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected':'' }}>In Progress</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected':'' }}>Completed</option>
                                    <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected':'' }}>On Hold</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $task->start_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $task->end_date ?? '') }}" required>
                            </div>
                            
                            
                            <div class="col-md-12">
                                <label>Remarks / Description</label>
                                <textarea name="descriptions" class="form-control" rows="3" > {{ old('descriptions', $task->descriptions ?? '') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Project</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('partials.alertModal', [
                'dataDetails' => $task,
                'table'=>'tasks'
                ]
                )
        @endforeach
        <!--- End Edit modal --->
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            responsive: true,
            pageLength: 10,
            order: [
                [3, 'desc']
            ], // sort by “Joined At” descending
            language: {
                search: "Filter records:",
                lengthMenu: "Show _MENU_ rows per page"
            }
            // buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
@endpush