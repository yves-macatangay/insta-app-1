<style>
    .modal-body {
        overflow-y:scroll;
        max-height:300px;
    }
</style>
<div class="modal fade" id="comments">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-secondary">
                <h4 class="h4 text-secondary">Recent Comments</h4>
            </div>
            <div class="modal-body text-secondary">
                @forelse($user->comments->take(5) as $comment)
                    <div class="border border-primary rounded-2 mb-2 px-3 py-2">
                        {{ $comment->body }}
                        <hr class="my-2">
                        <span class="small">
                            Replied to <a href="{{ route('post.show', $comment->post_id)}}" class="text-decoration-none">{{ $comment->post->user->name }}'s post</a>
                        </span>
                    </div>
                @empty 
                    <p class="h4">No recent comments.</p>
                @endforelse
            </div>
            <div class="modal-footer border-0">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>
    </div>
</div>