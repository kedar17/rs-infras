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


    <!-- expense Tracking -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Expense Planning</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addexpenseModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Expense
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="mb-4">
                <select
                    id="expenseselect"
                    class="form-select w-50"
                    data-url="{{ route('filter-expense') }}">
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
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Payment Reference</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        @foreach($expenses as $expense)
                        <tr>
                           
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->project->name }}</td>
                            <td>{{ $expense->category->name }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->payment_mode }}</td>
                            <td>{{ $expense->payment_ref }}</td>
                            <td>{{ $expense->remarks }}</td>
                            <td>{{ $expense->created_at ?? '—' }}</td>
                            <td>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add expense Modal -->
        <div class="modal fade" id="addexpenseModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="addexpenseForm" method="POST" action="{{ route('add-expense') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New expense</h5>
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
                        <div class="col-md-4">
                            <label>Amount (₹)</label>
                            <input type="text" class="form-control" name="amount" placeholder="e.g., 5000">
                        </div>
                        
                        <div class="col-md-4">
                            <label>Mode of Payment</label>
                            <select class="form-select" name="payment_mode">
                                <option value="cash"> Cash</option>
                                <option value="upi"> UPI</option>
                                <option value="bank__transfer">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Reference No.</label>
                            <input type="text" class="form-control" name="payment_ref">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks" required
                                placeholder="e.g., Material for basement slab"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Add expense</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit expense Modal -->
        @foreach($expenses as $expense)
        <div class="modal fade" id="editexpenseModal-{{ $expense->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editexpenseForm" method="POST" action="{{ route('expense.update', $expense->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>expense</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $expense->project_id ? 'selected' : '' }}>
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
                                <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Estimated Cost (₹)</label>
                            <input type="text" class="form-control" name="est_cost" value="{{ old('est_cost', $expense->est_cost ?? '') }}" placeholder="e.g., 5000" >
                        </div>
                        
                       <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option value="draft"> Draft</option>
                                <option value="submitted"> Submitted</option>
                                <option value="approved">Approved</option>
                                <option value="over-expense">Overexpense</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', $expense->date ?? '') }}">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks" value="{{ old('remarks', $expense->remarks ?? '') }}" required
                                placeholder="e.g., Estimation for slab work"></textarea>
                        </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save expense</button>
                    </div>
                </form>
            </div>
        </div>
        @include('partials.alertModal', [
        'dataDetails' => $expense,
        'table'=>'expenses'
        ]
        )
        @endforeach
        <!--- End Edit modal --->
    </div>
    @include('partials.ajax-expense-rows', [
    'expenses' => $expenses,
    'expenses'=> [] // initially empty
    ])
</div>
<!-- End of Container -->
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('expenseselect');
        const tbody = document.getElementById('expenseTableBody');
        const url = select.dataset.url;
        // console.log('select element →', select);
        // console.log('tbody element →', tbody);
        select.addEventListener('change', async () => {
            const expenseId = select.value;
            //console.log('Selected expenseId:', expenseId);

            // Loading placeholder
            tbody.innerHTML = `
      <tr>
        <td colspan="10" class="py-4">Loading...</td>
      </tr>
    `;

            try {
                const response = await fetch(`${url}?expense_id=${expenseId}`, {
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