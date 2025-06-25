<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample posts
        $post1 = Post::create([
            'title' => 'Welcome to Multi-Level Comments',
            'content' => 'This is a demonstration of a multi-level commenting system built with Laravel. You can create nested replies up to 3 levels deep.'
        ]);

        $post2 = Post::create([
            'title' => 'How Deep Can Comments Go?',
            'content' => 'This post demonstrates the depth limitation feature. Try creating replies and see how the system prevents comments from going beyond the maximum depth of 3 levels.'
        ]);

        $post3 = Post::create([
            'title' => 'Scheduled Command Demo',
            'content' => 'This post shows how the scheduled command works to clean up old comments. The system automatically removes old comments with empty content or no replies.'
        ]);

        // Create sample comments for the first post
        $comment1 = Comment::create([
            'content' => 'Great post! This commenting system looks really useful.',
            'post_id' => $post1->id,
            'parent_comment_id' => null,
        ]);

        $comment2 = Comment::create([
            'content' => 'I agree! The nested structure makes conversations easy to follow.',
            'post_id' => $post1->id,
            'parent_comment_id' => $comment1->id,
        ]);

        $comment3 = Comment::create([
            'content' => 'Yes, and the depth limitation prevents it from becoming too messy.',
            'post_id' => $post1->id,
            'parent_comment_id' => $comment2->id,
        ]);

        // This should be at max depth (3), so no more replies allowed
        Comment::create([
            'content' => 'This is the maximum depth level.',
            'post_id' => $post1->id,
            'parent_comment_id' => $comment3->id,
        ]);

        // Create some comments for the second post
        Comment::create([
            'content' => 'Let me test the depth limitation!',
            'post_id' => $post2->id,
            'parent_comment_id' => null,
        ]);

        // Create some old comments with empty content for cleanup testing
        Comment::create([
            'content' => '',
            'post_id' => $post3->id,
            'parent_comment_id' => null,
            'created_at' => now()->subDays(35), // Older than 30 days
            'updated_at' => now()->subDays(35),
        ]);

        Comment::create([
            'content' => null,
            'post_id' => $post3->id,
            'parent_comment_id' => null,
            'created_at' => now()->subDays(40), // Older than 30 days
            'updated_at' => now()->subDays(40),
        ]);
    }
}
