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


    <!-- budget Tracking -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Budget Planning</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addbudgetModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Budget
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="mb-4">
                <select
                    id="budgetselect"
                    class="form-select w-50"
                    data-url="{{ route('filter-budget') }}">
                    <option value="" selected>--- Select budget ---</option>
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
                            <th>Estimated Cost</th>
                            <th>Category</th>
                            <th>Remarks</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="budgetTableBody">
                        @foreach($budgets as $budget)
                        <tr>
                           
                            <td>{{ $budget->id }}</td>
                            <td>{{ $budget->project->name }}</td>
                            <td>{{ $budget->est_cost }}</td>
                            <td>{{ $budget->category->name }}</td>
                            <td>{{ $budget->remarks }}</td>
                            <td>{{ $budget->date ?? '—' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $budget->status === 'Delivered' ? 'success' : 'secondary' }}">
                                    {{ $budget->status }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editbudgetModal-{{ $budget->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $budget->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add budget Modal -->
        <div class="modal fade" id="addbudgetModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="addbudgetForm" method="POST" action="{{ route('add-budget') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Budget</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label>Category</label>
                            <select class="form-select" name="category_id" required>
                                <option selected disabled>--- Select Category --- </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Estimated Cost (₹)</label>
                            <input type="text" class="form-control" name="est_cost" placeholder="e.g., 5000">
                        </div>
                        
                        <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option value="draft"> Draft</option>
                                <option value="submitted"> Submitted</option>
                                <option value="approved">Approved</option>
                                <option value="over-budget">OverBudget</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks" required
                                placeholder="e.g., Estimation for slab work"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Add Budget</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit budget Modal -->
        @foreach($budgets as $budget)
        <div class="modal fade" id="editbudgetModal-{{ $budget->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editbudgetForm" method="POST" action="{{ route('budget.update', $budget->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Budget</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Project</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $budget->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select class="form-select" name="category_id" required>
                                <option selected disabled>--- Select Category --- </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $budget->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Estimated Cost (₹)</label>
                            <input type="text" class="form-control" name="est_cost" value="{{ old('est_cost', $budget->est_cost ?? '') }}" placeholder="e.g., 5000" >
                        </div>
                        
                       <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option value="draft"> Draft</option>
                                <option value="submitted"> Submitted</option>
                                <option value="approved">Approved</option>
                                <option value="over-budget">OverBudget</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', $budget->date ?? '') }}">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks" value="{{ old('remarks', $budget->remarks ?? '') }}" required
                                placeholder="e.g., Estimation for slab work"></textarea>
                        </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Budget</button>
                    </div>
                </form>
            </div>
        </div>
        @include('partials.alertModal', [
        'dataDetails' => $budget,
        'table'=>'budgets'
        ]
        )
        @endforeach
        <!--- End Edit modal --->
    </div>
    @include('partials.ajax-budget-rows', [
    'budgets' => $budgets,
    'budgets'=> [] // initially empty
    ])
</div>
<!-- End of Container -->
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('budgetselect');
        const tbody = document.getElementById('budgetTableBody');
        const url = select.dataset.url;
        console.log('select element →', select);
        console.log('tbody element →', tbody);
        select.addEventListener('change', async () => {
            const budgetId = select.value;
            console.log('Selected budgetId:', budgetId);

            // Loading placeholder
            tbody.innerHTML = `
      <tr>
        <td colspan="10" class="py-4">Loading...</td>
      </tr>
    `;

            try {
                const response = await fetch(`${url}?budget_id=${budgetId}`, {
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
