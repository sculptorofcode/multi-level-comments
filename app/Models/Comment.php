<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = ['content', 'post_id', 'parent_comment_id', 'depth'];

    const MAX_DEPTH = 3;

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function canHaveReplies(): bool
    {
        return $this->depth < self::MAX_DEPTH;
    }

    public function calculateDepth(): int
    {
        if ($this->parent_comment_id === null) {
            return 0;
        }

        return $this->parent->depth + 1;
    }

    protected static function booted(): void
    {
        static::creating(function ($comment) {
            if ($comment->parent_comment_id) {
                $parent = self::find($comment->parent_comment_id);
                if ($parent) {
                    $newDepth = $parent->depth + 1;
                    
                    // Prevent exceeding max depth
                    if ($newDepth > self::MAX_DEPTH) {
                        throw new \Exception('Maximum comment depth exceeded');
                    }
                    
                    $comment->depth = $newDepth;
                }
            } else {
                $comment->depth = 0;
            }
        });
    }
}
