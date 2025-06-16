<?php

// app/Models/Series.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $primaryKey = 'series_id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function posts()
    // {
    //     return $this
    //         ->belongsToMany(Post::class, 'series_posts')
    //         ->using(\App\Models\SeriesPost::class)
    //         ->withPivot('position')
    //         ->orderBy('position');
    // }
}