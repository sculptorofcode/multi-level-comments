@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>All Posts</h1>
        
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                        <p class="card-text">
                            <small class="text-muted">
                                {{ $post->created_at->diffForHumans() }} • 
                                {{ $post->comments->count() }} comments
                            </small>
                        </p>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info">
                <h4>No posts yet!</h4>
                <p>Be the first to create a post.</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
            </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('posts.create') }}" class="btn btn-success w-100">Create New Post</a>
            </div>
        </div>
    </div>
</div>
@endsection
