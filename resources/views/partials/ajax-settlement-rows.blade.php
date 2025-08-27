@forelse ($settlements as $settlement)
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
@empty

@endforelse