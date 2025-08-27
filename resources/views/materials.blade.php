@extends('layouts.app')
@section('content')
<!-- Begin Page Content -->
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


    <!-- Material Tracking -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Material Tracking</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addMaterialModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Material
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="mb-4">
                <select
                    id="projectSelect"
                    class="form-select w-50"
                    data-url="{{ route('filter-material') }}">
                    <option value="" selected>--- Select Project ---</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card shadow mb-4">
                <table class="table table-bordered text-center align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Vendor</th>
                            <th>Request Date</th>
                            <th>Linked Task</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="materialsTableBody">
                        @foreach($materials as $material)
                        <tr>
                           
                            <td>{{ $material->id }}</td>
                            <td>{{ $material->project->name }}</td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->quantity }}</td>
                            <td>{{ $material->unit }}</td>
                            <td>{{ $material->vendor }}</td>
                            <td>{{ $material->request_date ?? '—' }}</td>
                            <td>{{ $material->task->title }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $material->status === 'Delivered' ? 'success' : 'secondary' }}">
                                    {{ $material->status }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editMaterialModal-{{ $material->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $material->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Material Modal -->
        <div class="modal fade" id="addMaterialModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="addMaterialForm" method="POST" action="{{ route('add-material') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-4">
                            <label>Project</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Material Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Sand" required>
                        </div>
                        <div class="col-md-4">
                            <label>Vendor</label>
                            <input type="text" class="form-control" name="vendor" placeholder="e.g., XYZ Traders">
                        </div>
                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control" placeholder="e.g., 500" required>
                        </div>
                        <div class="col-md-4">
                            <label>Unit</label>
                            <select class="form-select" name="unit">
                                <option>Bags</option>
                                <option>KG</option>
                                <option>Cubic Meter</option>
                                <option>Ton</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Unit/Cost</label>
                            <input type="number" name="unit_cost" class="form-control" placeholder="per unit cost">
                        </div>


                        <div class="col-md-6">
                            <label>Request/Delivery Date</label>
                            <input type="date" class="form-control" name="request_date">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option>Pending</option>
                                <option>Delivered</option>
                                <option>Used</option>
                                <option>Delayed</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Linked Task / Notes</label>
                            <select class="form-select" name="task_id" required>
                                <option selected disabled>--- Select Task --- </option>
                                @foreach($tasks as $task)
                                <option value="{{ $task->id }}">
                                    {{ $task->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Add Material</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Project Modal -->
        @foreach($materials as $material)
        <div class="modal fade" id="editMaterialModal-{{ $material->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editMaterialForm" method="POST" action="{{ route('materials.update', $material->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-4">
                            <label>Project</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $material->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Material Name</label>
                            <input type="text" name="name" value="{{ old('name', $material->name ?? '') }}" class="form-control" placeholder="e.g., Sand" required>
                        </div>
                        <div class="col-md-4">
                            <label>Vendor</label>
                            <input type="text" class="form-control" name="vendor" value="{{ old('vendor', $material->vendor ?? '') }}" placeholder="e.g., XYZ Traders">
                        </div>
                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input type="text" name="quantity" value="{{ old('quantity', $material->quantity ?? '') }}" class="form-control" placeholder="e.g., 500" required>
                        </div>
                        <div class="col-md-4">
                            <label>Unit</label>
                            <select class="form-select" name="unit">
                                <option>Bags</option>
                                <option>KG</option>
                                <option>Cubic Meter</option>
                                <option>Ton</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Unit/Cost</label>
                            <input type="number" name="unit_cost" value="{{ old('unit_cost', $material->unit_cost ?? '') }}" class="form-control" placeholder="per unit cost">
                        </div>
                        <div class="col-md-6">
                            <label>Request/Delivery Date</label>
                            <input type="date" class="form-control" name="request_date" value="{{ old('request_date', $material->request_date ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option>Pending</option>
                                <option>Delivered</option>
                                <option>Used</option>
                                <option>Delayed</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Linked Task / Notes</label>
                            <select class="form-select" name="task_id" required>
                                <option selected disabled>--- Select Task --- </option>
                                @foreach($tasks as $task)

                                <option value="{{ $task->id }}" {{ $task->id == $material->task_id ? 'selected' : '' }}>
                                    {{ $task->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Material</button>
                    </div>
                </form>
            </div>
        </div>
        @include('partials.alertModal', [
        'dataDetails' => $material,
        'table'=>'materials'
        ]
        )
        @endforeach
        <!--- End Edit modal --->
    </div>
    @include('partials.ajax-material-rows', [
    'projects' => $projects,
    'tasks' => $tasks,
    'materials'=> [] // initially empty
    ])
</div>
<!-- End of Container -->
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('projectSelect');
        const tbody = document.getElementById('materialsTableBody');
        const url = select.dataset.url;
        console.log('select element →', select);
        console.log('tbody element →', tbody);
        select.addEventListener('change', async () => {
            const projectId = select.value;
            console.log('Selected projectId:', projectId);

            // Loading placeholder
            tbody.innerHTML = `
      <tr>
        <td colspan="10" class="py-4">Loading...</td>
      </tr>
    `;

            try {
                const response = await fetch(`${url}?project_id=${projectId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) throw new Error(response.statusText);

                const data = await response.json();
                console.log('AJAX response:', data);

                // Replace rows
                tbody.innerHTML = data.html;
            } catch (error) {
                console.error('Fetch error:', error);
                tbody.innerHTML = `
        <tr>
          <td colspan="10" class="py-4 text-danger">
            An error occurred while fetching data.
          </td>
        </tr>
      `;
            }
        });
    });
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