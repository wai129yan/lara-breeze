<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    // protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'profile_image_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $dates = ['deleted_at'];

    // Example Eloquent relationship: A user can have many posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function publishedPosts(): HasMany
    {
        return $this->posts()->where('status', 'published');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNotNull('parent_id');
    }

    /**
     * Get draft posts by the user
     */
    public function draftPosts(): HasMany
    {
        return $this->posts()->where('status', 'draft');
    }

    public function following()
    {
        return $this
            ->belongsToMany(User::class, 'user_follows', 'follower_id', 'followed_id')
            ->withTimestamps();
    }

    /**
     * Users that are following this user (followers)
     */
    public function followers()
    {
        return $this
            ->belongsToMany(User::class, 'user_follows', 'followed_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    /**
     * Check if this user is followed by another user
     */
    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Follow a user
     */
    public function follow(User $user)
    {
        if ($this->id === $user->id) {
            return false;  // Can't follow yourself
        }

        return $this->following()->syncWithoutDetaching([$user->id]);
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user)
    {
        return $this->following()->detach($user->id);
    }

    /**
     * Toggle follow status
     */
    public function toggleFollow(User $user)
    {
        if ($this->isFollowing($user)) {
            return $this->unfollow($user);
        }

        return $this->follow($user);
    }

    /**
     * Get followers count
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    /**
     * Get following count
     */
    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    // OR if you want claps received by user's posts:

    /**
     * Claps received on this user's posts
     */
    public function receivedClaps()
    {
        return $this->hasManyThrough(Clap::class, Post::class);
    }
}
