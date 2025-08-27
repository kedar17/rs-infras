@forelse ($budgets as $budget)
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
@empty
<tr>
    <!-- <td colspan="10" class="text-center py-4">
        No budgets found for this project.
    </td> -->
</tr>
@endforelse