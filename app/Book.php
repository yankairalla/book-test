<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // public function category() {
    //     $this->belongsToMany('\App\Category');
    // }

    public function user() {
        $this->belongsTo(\App\User::class);
    }
}
