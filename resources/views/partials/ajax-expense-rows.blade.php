@forelse ($expenses as $expense)
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
@empty
<tr>
    <!-- <td colspan="10" class="text-center py-4">
        No expenses found for this project.
    </td> -->
</tr>
@endforelse