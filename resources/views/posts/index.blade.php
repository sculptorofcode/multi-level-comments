@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">
                <i class="fas fa-newspaper me-2"></i>All Posts
            </h1>
            <span class="badge fs-6">{{ $posts->count() }} Posts</span>
        </div>
        
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title post-title fs-4">{{ $post->title }}</h5>
                        <p class="card-text text-dark mb-3">{{ Str::limit($post->content, 200) }}</p>
                        <div class="stats-container mb-3">
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-comments"></i>
                                {{ $post->comments->count() }} comments
                            </div>
                        </div>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">
                            <i class="fas fa-book-open me-2"></i>Read More
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No posts yet!</h4>
                    <p class="text-muted mb-4">Be the first to create a post and start the conversation.</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create First Post
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-rocket me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('posts.create') }}" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-plus me-2"></i>Create New Post
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="stat-item mb-2">
                    <i class="fas fa-newspaper"></i>
                    {{ $posts->count() }} Total Posts
                </div>
                <div class="stat-item">
                    <i class="fas fa-comments"></i>
                    {{ $posts->sum(function($post) { return $post->comments->count(); }) }} Total Comments
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
