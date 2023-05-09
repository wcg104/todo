@foreach ($notes as $key => $note)
    <tr class="fw-normal">


        <td class="align-middle">
            {{ ($notes->currentpage() - 1) * $notes->perpage() + $key + 1 }}
        </td>

        <td class="align-middle">
            <span>{{ $note->title }}</span>
        </td>
        <td class="align-middle">
            @if ($note->priority_level == 1)
                <h6 class="mb-0"><span class="badge bg-danger text-light">High priority</span>
                </h6>
            @elseif ($note->priority_level == 2)
                <h6 class="mb-0"><span class="badge bg-warning text-light">Middle
                        priority</span></h6>
            @else
                <h6 class="mb-0"><span class="badge bg-success text-light">Low priority</span>
                </h6>
            @endif
        </td>
        <td class="align-middle">
            <span>{{ $note->created_at->format('d/m/Y') }}</span>
        </td>
        <td class="align-middle">


            @foreach ($note->tags as $tag)
                <span class="badge badge-primary">{{ $tag->title }}</span>
            @endforeach

        </td>
        <td class="align-middle">
            <span>{{ $note->status }}</span>
        </td>

        <td class="align-middle">
            <a class="noteDone" data-id={{ $note->id }} data-action="{{ route('notes.done', $note->id) }}"
                title="Done"><i class="fas fa-check text-success me-3 mr-3"></i></a>

            <a title="Remove" data-id="{{ $note->id }}" data-action="{{ route('notes.destroy', $note->id) }}"
                class="deleteRecord"><i class="fas fa-trash-alt text-danger mr-3"></i></a>

            <a href="{{ route('notes.edit', ['note' => $note->id]) }}" data-mdb-toggle="tooltip" title="edit"><i
                    class="fas fa-pencil-alt mr-3 text-secondary" aria-hidden="true"></i></a>
            <a href="{{ route('notes.show', ['note' => $note->id]) }}" data-mdb-toggle="tooltip" title="view"><i
                    class="fa fa-eye mr-3" aria-hidden="true"></i></a>

            <a title="archive" data-id={{ $note->id }}
                data-action="{{ route('notes.archive', [$note->id, '1']) }}" class="archiveNote"><i
                    class="fa fa-archive text-secondary"></i></a>
        </td>
    </tr>
@endforeach

<tr class="">
    <td class="paginet" colspan="3">
        {{ $notes->links() }}
    </td>
</tr>
{{-- <script src="{{ asset('/js/custom/user/notes.js') }}"></script> --}}
