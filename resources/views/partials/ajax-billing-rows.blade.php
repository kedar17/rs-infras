@forelse ($billings as $billing)
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
@empty
<!-- <tr>
    <td colspan="10" class="text-center py-4">
        No budgets found for this project.
    </td>
</tr> -->
@endforelse