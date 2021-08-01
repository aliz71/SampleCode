<?php

use Illuminate\Database\Seeder;
use \App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Book::class, 100)->create();
    }
}
