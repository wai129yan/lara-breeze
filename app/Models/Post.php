<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'featured_image',
        'subtitle',
        'slug',
        'content',
        'status',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // In App\Models\Post.php

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function parentComments(): HasMany
    {
        return $this->comments()->whereNull('parent_id')->with(['replies.user', 'user']);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNotNull('parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class, 'post_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',  // pivot table name
            'post_id',  // foreign key for current model
            'tag_id'  // foreign key for related model
        )->withTimestamps();  // include created_at and updated_at from pivot table
    }

    public function tagName()
    {
        // return $this->tags;
        // return $this->tags()->pluck('name')->implode(', ');
        return $this->tags()->pluck('name');
    }

    public function clapCounts()
    {
        return $this->hasMany(Clap::class)->sum('clap_count');
    }

    // public function comments(): HasMany
    // {
    //     return $this->hasMany(Comment::class)->whereNull('parent_id');  // Only top-level comments
    // }
}
