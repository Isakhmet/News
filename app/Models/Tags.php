<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function relation(){
        return $this->hasMany('App\Models\NewsTags', 'tags_id', 'id');
    }
}
