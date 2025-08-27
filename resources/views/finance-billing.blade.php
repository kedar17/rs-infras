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
        <h1 class="h3 mb-0"><b>Finance & Billing</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addFinanceModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Billing Entry
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="mb-4">
                <select
                    id="projectSelect"
                    class="form-select w-50"
                    data-url="{{ route('filter-billing') }}">
                    <option value="" selected>-- Select Project --</option>
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
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Vendor / Party</th>
                            <th>Reference</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ajaxTableBody">
                        @foreach($billings as $billing)
                        <tr>

                            <td>{{ $billing->id }}</td>
                            <td>{{ $billing->project->name }}</td>
                            <td>{{ $billing->BillingType->type }}</td>
                            <td>{{ $billing->category->name }}</td>
                            <td>{{ $billing->amount }}</td>
                            <td>{{ $billing->contact->name ?? '-'}}</td>
                            <td>{{ $billing->invoice_number ?? '—' }}</td>
                            <td>{{ $billing->remarks ?? '—' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $billing->status === 'Delivered' ? 'success' : 'secondary' }}">
                                    {{ $billing->status }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBillingModal-{{ $billing->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $billing->id }}">
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
        <div class="modal fade" id="addFinanceModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="addbillingForm" method="POST" action="{{ route('add-billing') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Finance / Billing Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Project</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>-- Select Project -- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-3">
                            <label>Type</label>
                            <select class="form-select" name="type_id">
                                <option selected disabled>-- Select Type --</option>
                                @foreach($billingTypes as $billingType)
                                <option value="{{ $billingType->id }}">
                                    {{ $billingType->type }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select class="form-select" name="category_id" required>
                                <option selected disabled>-- Select Category -- </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Vendor / Party Name</label>
                            <select class="form-select" name="contact_id" required>
                                <option selected disabled>-- Select Contact -- </option>
                                @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">
                                    {{ $contact->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Amount (₹)</label>
                            <input type="number" name="amount" class="form-control" placeholder="e.g., 25000"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option>Paid</option>
                                <option>Unpaid</option>
                                <option>Partial</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Invoice / Ref No.</label>
                            <input type="text" name="invoice_number" class="form-control" placeholder="e.g., INV-203">
                        </div>
                        <div class="col-md-12">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks"
                                placeholder="Any description or notes"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success">Add Entry</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit budget Modal -->
        @foreach($billings as $billing)
        <div class="modal fade" id="editBillingModal-{{ $billing->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editbudgetForm" method="POST" action="{{ route('billing.update', $billing->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Budget</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>budget</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $billing->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" value="{{ old('date', $billing->date ?? '') }}" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-3">
                            <label>Type</label>
                            <select class="form-select" name="type_id">
                                <option selected disabled>-- Select Type --</option>
                                @foreach($billingTypes as $billingType)
                                <option value="{{ $billingType->id }}" {{$billingType->id == $billing->type_id ? 'selected':''}}>
                                    {{ $billingType->type }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select class="form-select" name="category_id" required>
                                <option selected disabled>--- Select Category --- </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $billing->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label>Vendor / Party Name</label>
                            <select class="form-select" name="contact_id" required>
                                <option selected disabled>-- Select Contact -- </option>
                                @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}" {{$contact->id == $billing->contact_id ? 'selected':''}}>
                                    {{ $contact->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Amount (₹)</label>
                            <input type="number" name="amount" value="{{ old('amount', $billing->amount ?? '') }}" class="form-control" placeholder="e.g., 25000"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option>Paid</option>
                                <option>Unpaid</option>
                                <option>Partial</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Invoice / Ref No.</label>
                            <input type="text" name="invoice_number" value="{{ old('invoice_number', $billing->invoice_number ?? '') }}" class="form-control" placeholder="e.g., INV-203">
                        </div>
                        <div class="col-md-12">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="2" name="remarks"
                                placeholder="Any description or notes">{{ old('remarks', $billing->remarks ?? '') }}</textarea>
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
        'dataDetails' => $billing,
        'table'=>'billings'
        ]
        )
        @endforeach
        <!--- End Edit modal --->
    </div>
    @include('partials.ajax-billing-rows', [
    'billings' => $billings,
    'billings'=> [] // initially empty
    ])
</div>
<!-- End of Container -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('projectSelect');
        const tbody = document.getElementById('ajaxTableBody');
        const url = select.dataset.url;
        console.log('select element →', select);
        console.log('tbody element →', tbody);
        select.addEventListener('change', async () => {
            const projectId = select.value;
            console.log('Selected budgetId:', projectId);

            // Loading placeholder
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="py-4">Loading...</td>
                </tr>
                `;

            try {
                const response = await fetch(`${url}?billing_id=${projectId}`, {
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