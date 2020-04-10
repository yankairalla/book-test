<?php

use \App\Library;
use \App\Book;
use Illuminate\Database\Seeder;

class LibraryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Library::class, 4)->create();

        $books = Book::all();

        $libraries = Library::all();

        $books->each(function($book) use ($libraries) {
            $book->libraries()->attach(
                $libraries->random(rand(1,3))->pluck('id')->toArray()
            );
        });
    }
}
