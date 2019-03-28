<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    public $timestamps = false;

    protected $table = 'locales';

    protected $fillable = [
        'locale',
        'name'
    ];

    public function newsLocale(){
        return $this->hasMany('App\Models\News', 'locale_id', 'id');
    }
}
