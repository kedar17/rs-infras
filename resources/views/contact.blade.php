@extends('layouts.app')
@section('content')

        <!-- Begin Page container-fluid -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h1 class="h3 mb-0  "><b>Contact Management</b></h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#addcontactModal"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus text-white-50"></i> Add New Contact</a>
            </div>

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="contactTableBody">
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->type }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone}}</td>
                                    <td>{{ $contact->address}}</td>
                                    <td><span class="badge {{ $contact->status ? 'bg-success' : 'bg-danger' }} ">{{ $contact->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        
                                        <button class="btn btn-sm btn-warning" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editcontactModal-{{ $contact->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#alertModal-{{ $contact->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- More contacts dynamically injected -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- End ========================== Page parts ====================== -->

            <!-- Add contact Modal -->
            <div class="modal fade" id="addcontactModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" id="addcontactForm" method="POST" action="{{ route('add-contact') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add New contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required />
                            </div>
                            <div class="mb-3">
                                <label>Type</label>
                                <select class="form-select" name="type">
                                <option>Client</option>
                                <option>Vendor</option>
                            </select>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                            </div>
                            <div class="mb-3">
                                <label>Phone</label>
                                <input id="phone" type="tel" maxlength="10" class="form-control" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input id="address" type="text" class="form-control" name="address" required >
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
                            <button type="submit" class="btn btn-primary">Save contact</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--- Edit contact Modal --->
            @foreach($contacts as $contact)
            <div class="modal fade" id="editcontactModal-{{ $contact->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" id="editcontactForm" method="POST" action="{{ route('contacts.update', $contact->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $contact->name ?? '') }}" required />
                            </div>
                            <div class="mb-3">
                                <label>Type</label>
                                <select class="form-select" name="type">
                                <option {{$contact->type == 'Client' ? 'Selected' : ''}}>Client</option>
                                <option {{$contact->type == 'Vendor' ? 'Selected' : ''}}>Vendor</option>
                            </select>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $contact->email ?? '') }}" required />
                            </div>
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone', $contact->phone ?? '') }}" required />
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address', $contact->address ?? '') }}" required />
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
                            <button type="submit" class="btn btn-primary">Save contact</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('partials.alertModal', [
                'dataDetails' => $contact,
                'table'=>'contacts'
                ]
                )
            @endforeach
            <!--- End Edit modal --->
        </div>
        <!-- /.container-fluid -->
@endsection