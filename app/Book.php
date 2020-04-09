<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
     protected $fillable = ['title', 'author'];

    // public function category() {
    //     $this->belongsToMany('\App\Category');
    // }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }
}
