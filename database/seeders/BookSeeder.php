<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::truncate(); // Clear previous entries to avoid duplicates

        Book::insert([
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'image' => 'images/book1.jpg',
                'popularity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'image' => 'images/book2.jpg',
                'popularity' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'image' => 'images/book3.jpg',
                'popularity' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
