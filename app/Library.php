<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = ['name'];

    public function books() {
        return $this->belongsToMany(\App\Book::class, 'book_library','book_id', 'library_id');
    }
}
