<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    protected $primaryKey = 'tag_id';

    // Optional: Use timestamps with timezone
    public $timestamps = true;
}
