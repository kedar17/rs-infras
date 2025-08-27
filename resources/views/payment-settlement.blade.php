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
        <h1 class="h3 mb-0"><b>Payment & Settlement Logs</b></h1>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addFinanceModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus text-white-50"></i> Add Payment Logs
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="mb-4">
                <select
                    id="projectSelect"
                    class="form-select w-50"
                    data-url="{{ route('filter-settlement') }}">
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
                            <th>Project</th>
                            <th>Paid To</th>
                            <th>Amount</th>
                            <th>Mode</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Settled By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ajaxTableBody">
                        @foreach($settlements as $settlement)
                        <tr>
                            <td>{{ $settlement->id }}</td>
                            <td>{{ $settlement->date }}</td>
                            <td>{{ $settlement->project->name }}</td>
                            <td>{{ $settlement->contact->name }}</td>
                            <td>{{ $settlement->amount }}</td>
                            <td>{{ $settlement->mode }}</td>
                            <td>{{ $settlement->reference_no ?? '—' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $settlement->status === 'Delivered' ? 'success' : 'secondary' }}">
                                    {{ $settlement->status }}
                                </span>
                            </td>
                            <td>{{ $settlement->user->name ?? '-'}}</td>
                            
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editsettlementModal-{{ $settlement->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $settlement->id }}">
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
                <form class="modal-content" id="addsettlementForm" method="POST" action="{{ route('add-settlement') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment Entry</h5>
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
                        <div class="col-md-6">
                            <label>Paid To</label>
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
                            <label>Mode of Payment</label>
                            <select class="form-select" name="mode">
                                <option>Cash</option>
                                <option>UPI</option>
                                <option>Bank Transfer</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Transaction ID / Reference</label>
                            <input type="text" name="reference_no" class="form-control" placeholder="e.g., INV-203">
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
                            <label>Settled By</label>
                            <select class="form-select" name="settled_by" required>
                                <option selected disabled>-- Select User -- </option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date">
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
        @foreach($settlements as $settlement)
        <div class="modal fade" id="editsettlementModal-{{ $settlement->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editbudgetForm" method="POST" action="{{ route('settlement.update', $settlement->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Project</label>
                            <select class="form-select" name="project_id" required>
                                <option selected disabled>--- Select Project --- </option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $settlement->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" value="{{ old('date', $settlement->date ?? '') }}" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-3">
                            <label>Type</label>
                            
                        </div>
                        <div class="col-md-6">
                            <label>Paid To</label>
                            <select class="form-select" name="contact_id" required>
                                <option selected disabled>-- Select Contact -- </option>
                                @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}"{{$contact->id == $settlement->contact_id ? 'selected':''}}>
                                    {{ $contact->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Amount (₹)</label>
                            <input type="number" name="amount" value="{{ old('amount', $settlement->amount ?? '') }}" class="form-control" placeholder="e.g., 25000"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label>Mode of Payment</label>
                            <select class="form-select" name="mode">
                                <option>Cash</option>
                                <option>UPI</option>
                                <option>Bank Transfer</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                       
                        <div class="col-md-4">
                            <label>Invoice / Ref No.</label>
                            <input type="text" name="reference_no"  value="{{ old('reference_no', $settlement->reference_no ?? '') }}" class="form-control" placeholder="e.g., INV-203">
                        </div>
                         <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-select" name="status">
                                <option>Paid</option>
                                <option>Unpaid</option>
                                <option>Partial</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Settled By</label>
                            <select class="form-select" name="settled_by" required>
                                <option selected disabled>-- Select Contact -- </option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}"{{$user->id == $settlement->settled_by ? 'selected':''}}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                       <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', $settlement->date ?? '') }}">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
        @include('partials.alertModal', [
        'dataDetails' => $settlement,
        'table'=>'settlements'
        ]
        )
        @endforeach
        <!--- End Edit modal --->
    </div>
    @include('partials.ajax-settlement-rows', [
    'settlements' => $settlements,
    'settlements'=> [] // initially empty
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
                const response = await fetch(`${url}?settlement_id=${projectId}`, {
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