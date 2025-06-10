<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clap extends Model
{
    use HasFactory;

    // protected $primaryKey = 'clap_id';

    protected $fillable = [
        'post_id',
        'user_id',
        'clap_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
