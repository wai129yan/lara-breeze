<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Optional: If you're using mass assignment (factory, create, etc.)
    protected $fillable = [
        'name',
        'slug',
    ];

    // Optional: Custom primary key if needed
    // protected $primaryKey = 'tag_id';

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'post_tags',  // pivot table name
            'tag_id',  // foreign key for current model
            'post_id'  // foreign key for related model
        )->withTimestamps();
    }

    // Optional: Use timestamps with timezone
    public $timestamps = true;
}
