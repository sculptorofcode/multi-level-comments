@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Post Content -->
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title post-title">{{ $post->title }}</h1>
                <p class="card-text fs-5 text-dark mb-4">{{ $post->content }}</p>
                <div class="stats-container">
                    <div class="stat-item">
                        <i class="fas fa-clock"></i>
                        Posted {{ $post->created_at->diffForHumans() }}
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-comments"></i>
                        {{ $post->comments->count() }} comments
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Comment -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-pen me-2"></i>Add a Comment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  name="content" 
                                  rows="4" 
                                  placeholder="Share your thoughts..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Post Comment
                    </button>
                </form>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Comments 
                    <span class="badge ms-2">{{ $post->comments->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($post->rootComments->count() > 0)
                    @foreach($post->rootComments as $comment)
                        @include('partials.comment', ['comment' => $comment, 'post' => $post])
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted fs-5">No comments yet. Be the first to comment!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
