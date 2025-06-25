<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        try {
            Comment::create([
                'content' => $request->content,
                'post_id' => $post->id,
                'parent_comment_id' => $request->parent_comment_id,
            ]);

            return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('posts.show', $post)->with('error', 'Cannot add comment: ' . $e->getMessage());
        }
    }
}
