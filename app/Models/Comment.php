<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'content',
    ];

    /**
     * Get the post that owns the comment.
     */
    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'post_id');
    // }
    // /**
    //  * Get the user that owns the comment.
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Comment::class, 'parent_id');
    // }
    // public function replies(): HasMany
    // {
    //     return $this->hasMany(Comment::class, 'parent_id');
    // }
    // In your Comment model
    // public function replies()
    // {
    //     return $this->hasMany(Comment::class, 'parent_id');
    // }
    // // And ensure the inverse relationship includes post_id
    // public function parent()
    // {
    //     return $this->belongsTo(Comment::class, 'parent_id');
    // }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}