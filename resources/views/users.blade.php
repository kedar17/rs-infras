@extends('layouts.app')
@section('content')

<!-- Begin Page container-fluid -->
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
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0  "><b>User Management</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus text-white-50"></i> Add New User</a>
    </div>

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <table class="table table-striped" id="users-table" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role}}</td>
                            <td><span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }} ">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                            <td>

                                <button class="btn btn-sm btn-warning" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal-{{ $user->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger" type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        <!-- More users dynamically injected -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- End ========================== Page parts ====================== -->

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" id="addUserForm" method="POST" action="{{ route('add-user') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required />
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="Admin">Admin</option>
                            <option value="Contractor">Contractor</option>
                            <option value="Client">Client</option>
                            <option value="Engineer">Engineer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
    <!--- Edit User Modal --->
    @foreach($users as $user)
    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}" required />
                    </div>
                    <!-- <div class="mb-3">
                                <label>Password</label>
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div> -->
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="admin">Admin</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="mistree">Mistree</option>
                            <option value="labor">Labor</option>
                            <option value="Engineer">Engineer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
    @include('partials.alertModal', [
    'dataDetails' => $user,
    'table'=>'users'
    ]
    )
    @endforeach
    <!--- End Edit modal --->
</div>
<!-- /.container-fluid -->
@push('scripts')
<script>
  $(document).ready(function() {
    $('#users-table').DataTable({
      responsive: true,
      pageLength: 10,
      order: [[ 3, 'desc' ]],    // sort by “Joined At” descending
      language: {
        search: "Filter records:",
        lengthMenu: "Show _MENU_ rows per page"
      }
      // buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
  });
</script>
@endpush
@endsection
