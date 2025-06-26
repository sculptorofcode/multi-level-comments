<div class="comment depth-{{ $comment->depth }}">
    <div class="comment-content">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <p class="mb-0 fs-6 text-dark">{{ $comment->content }}</p>
                <div class="comment-meta">
                    <span class="text-muted">
                        <i class="fas fa-clock"></i>
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                    <span class="depth-indicator">
                        <i class="fas fa-layer-group me-1"></i>
                        Level {{ $comment->depth }}
                    </span>
                </div>
            </div>
            <div class="ms-3">
                @if($comment->canHaveReplies())
                    <button class="btn btn-sm btn-outline-primary" 
                            onclick="toggleReplyForm({{ $comment->id }})">
                        <i class="fas fa-reply me-1"></i>Reply
                    </button>
                @else
                    <small class="text-muted">
                        <i class="fas fa-ban me-1"></i>Max depth reached
                    </small>
                @endif
            </div>
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
                              rows="3" 
                              placeholder="Write your reply..."
                              required></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <button type="button" 
                            class="btn btn-sm btn-secondary" 
                            onclick="toggleReplyForm({{ $comment->id }})">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-paper-plane me-1"></i>Post Reply
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Nested Replies -->
    @if($comment->replies->count() > 0)
        <div class="replies-container">
            @foreach($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply, 'post' => $post])
            @endforeach
        </div>
    @endif
</div>
