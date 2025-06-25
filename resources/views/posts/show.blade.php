@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Post Content -->
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                <p class="card-text">{{ $post->content }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        Posted {{ $post->created_at->diffForHumans() }} • 
                        {{ $post->comments->count() }} comments
                    </small>
                </p>
            </div>
        </div>

        <!-- Add New Comment -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add a Comment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  name="content" 
                                  rows="3" 
                                  placeholder="Write your comment..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card">
            <div class="card-header">
                <h5>Comments ({{ $post->comments->count() }})</h5>
            </div>
            <div class="card-body">
                @if($post->rootComments->count() > 0)
                    @foreach($post->rootComments as $comment)
                        @include('partials.comment', ['comment' => $comment, 'post' => $post])
                    @endforeach
                @else
                    <p class="text-muted">No comments yet. Be the first to comment!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
