<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesPost extends Model
{
    protected $table = 'series_posts';

    protected $fillable = [
        'series_id',
        'post_id',
        'position',
    ];

    public $timestamps = false;
}