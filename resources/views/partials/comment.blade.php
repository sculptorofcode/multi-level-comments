<div class="comment depth-{{ $comment->depth }}">
    <div class="comment-content">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="mb-2">{{ $comment->content }}</p>
                <small class="text-muted">
                    {{ $comment->created_at->diffForHumans() }} • 
                    Depth: {{ $comment->depth }}
                </small>
            </div>
            @if($comment->canHaveReplies())
                <button class="btn btn-sm btn-outline-primary" 
                        onclick="toggleReplyForm({{ $comment->id }})">
                    Reply
                </button>
            @else
                <small class="text-muted">Max depth reached</small>
            @endif
        </div>
    </div>

    <!-- Reply Form -->
    @if($comment->canHaveReplies())
        <div id="reply-form-{{ $comment->id }}" class="reply-form">
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                <div class="mb-3">
                    <textarea class="form-control" 
                              name="content" 
                              rows="2" 
                              placeholder="Write your reply..."
                              required></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" 
                            class="btn btn-sm btn-secondary me-2" 
                            onclick="toggleReplyForm({{ $comment->id }})">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Post Reply</button>
                </div>
            </form>
        </div>
    @endif

    <!-- Nested Replies -->
    @if($comment->replies->count() > 0)
        @foreach($comment->replies as $reply)
            @include('partials.comment', ['comment' => $reply, 'post' => $post])
        @endforeach
    @endif
</div>
