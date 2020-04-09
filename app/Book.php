<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
     protected $fillable = ['title', 'author'];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function category() {
        return $this->belongTo(\App\Category::class);
    }

    public function library() {
        return $this->belongsToMany(\App\Library::class);
    }
}
