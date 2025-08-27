@extends('layouts.app')
@section('content')

<!-- Begin Page container-fluid -->
<div class="container-fluid">

    <!-- Project Management -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Project Management</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addProjectModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add New Project
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Project Value</th>
                            <th>Client</th>
                            <th>Assigned</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->name }} </td>
                            <td> {{ $project->budget }}</td>
                            <td>{{ $project->client->name ?? '—' }}</td>
                            <td>{{ $project->user->name ?? '—' }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date }}</td>
                            <td><span class="badge bg-success">{{ $project->status }}</span></td>
                            <td>
                                <a href="{{route('projects.details', $project->id)}}" class="btn btn-sm btn-secondary">View</a>
                                <button class="btn btn-sm btn-warning" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editProjectModal-{{ $project->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#alertModal-{{ $project->id }}">Delete
                                </button>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" id="addProjectForm" method="POST" action="{{ route('add-project') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3 px-4">
                    <div class="col-md-6">
                        <label>Project Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label>Project Valuation</label>
                        <input type="text" class="form-control" name="budget" required>
                    </div>
                    <div class="col-md-6">
                        <label>Client Name</label>
                        <select name="client_id" id="client_id" class="form-control" required>
                            <option value="">--- Select A Client ---</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-6">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="col-md-6">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="Planned">Planned</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="On Hold">On Hold</option>
                        </select>
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Project Modal -->
    @foreach($projects as $project)
            <div class="modal fade" id="editProjectModal-{{ $project->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" id="editProjectForm" method="POST" action="{{ route('projects.update', $project->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3 px-4">
                            <div class="col-md-6">
                                <label>Project Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $project->name ?? '') }}" required />
                            </div>
                            <div class="col-md-6">
                                <label>Project Valuation</label>
                                <input type="text" class="form-control" name="budget" value="{{ old('name', $project->budget ?? '') }}"required>
                               
                            </div>
                            <div class="col-md-6">
                                <label>Client Name</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    <option value="">--- Select A Client ---</option>
                                    
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                    </option>
                                       
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end_date"value="{{ old('end_date', $project->end_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select class="form-select" name="status">
                                    <option value="Planned">Planned</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="On Hold">On Hold</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Assigned To</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">--- Select A User ---</option>
                                    @foreach($users as $user)
                                         <option value="{{ $user->id }}" {{ $user->id == $project->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                    </option>
                                       
                                    @endforeach
                                </select>
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
                'dataDetails' => $project,
                'table'=>'projects'
                ]
                )
    @endforeach
    <!--- End Edit modal --->
</div>
<!-- /.container-fluid -->
@endsection