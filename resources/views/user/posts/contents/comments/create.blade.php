<form action="{{ route('comment.store', $post->id)}}" method="post">
    @csrf 
    <div class="input-group">
        <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm" placeholder="write a comment">{{ old('comment_body'.$post->id) }}</textarea>
        <input type="submit" value="Post" class="btn btn-sm btn-outline-secondary">
    </div>
    @error('comment_body'.$post->id)
        <p class="mb-0 text-danger small">{{ $message }}</p>
    @enderror
</form>