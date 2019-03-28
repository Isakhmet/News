<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTags extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'news_id',
        'tags_id'
    ];

    public function tags(){
        return $this->belongsTo('App\Models\Tags', 'id', 'tags_id');
    }
}
