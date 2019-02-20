<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [

    'title',
    'alias',
    'anons',
    'image',
    'image_copyright',
    'description',
    'status',
    'active_at',
    'active_end',
    'settings',
    'created_at',
    'updated_at'
    ];
}
