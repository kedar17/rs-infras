@extends('layouts.app')

@section('content')
 <!-- Begin Page container-fluid -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h1 class="h3 mb-0  "><b>Proposal Management</b></h1>
                <a href="{{ route('proposals.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                  <i class="fas fa-plus text-white-50"></i> New Proposal
                </a>
                        
            </div>

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Contact</th>
                                    <th>Total (₹)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="clientTableBody">
                                @foreach ($proposals as $rowIndex => $proposal)
                                <tr>
                                    <td>{{ ++$rowIndex }}</td>
                                    <td>{{ $proposal->reference }}</td>
                                    <td>{{ $proposal->updated_at }}</td>
                                    <td>{{ $proposal->client_name }}</td>
                                    <td>{{ $proposal->client_mobile }}</td>
                                    <td>
                                      {{ number_format($proposal->price_total,2) }}
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('proposals.show', $proposal->id) }}" target="_blank"
                                          class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('proposals.download', $proposal->id) }}"
                                          class="btn btn-sm btn-success">PDF</a>
                                        <a href="{{ route('proposals.edit', $proposal->id) }}" target="_blank"
                                          class="btn btn-sm btn-warning">Edit</a>
                                       
                                        <button class="btn btn-sm btn-danger" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#alertModal-{{ $proposal->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- More clients dynamically injected -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            @foreach ($proposals as $proposal)
            @include('partials.alertModal', [
                'dataDetails' => $proposal,
                'table'=>'proposals'
                ]
                )
          @endforeach
            <!--- End Edit modal --->
        </div>
        <!-- /.container-fluid -->
@endsection
