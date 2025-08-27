@forelse ($materials as $material)
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
@empty

@endforelse