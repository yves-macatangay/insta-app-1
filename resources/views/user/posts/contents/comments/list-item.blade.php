<div class="mt-3">
    <a href="{{ route('profile.show', $comment->user_id)}}" class="text-decoration-none fw-bold text-dark">{{ $comment->user->name }}</a>
    &nbsp;
    {{ $comment->body }}
    <div class="xsmall">
        <span class="text-muted">{{ date('D, M d Y', strtotime($comment->created_at)) }}</span>
        @if($comment->user_id == Auth::user()->id)
            &middot;
            <form action="{{ route('comment.destroy', $comment->id)}}" method="post" class="d-inline">
                @csrf 
                @method('DELETE')
                <button type="submit" class="bg-transparent border-0 shadow-none text-danger p-0">Delete</button>
            </form>
        @endif 
    </div>
</div>