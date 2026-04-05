<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin & User
        User::create([
            'name' => 'Admin Divyansh',
            'email' => 'admin@divyansh.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '9876543210',
        ]);

        // 2. Create Dummy Publisher
        $publisher = Publisher::create([
            'name' => 'Divyansh Publication',
            'address' => 'New Delhi, India',
            'contact_no' => '9876543211',
        ]);

        // 3. Create Dummy Authors (Jo humne UI mein use kiye the)
        $author1 = Author::create(['name' => 'Ved Prakash Panday', 'about' => 'A great storyteller and poet.']);
        $author2 = Author::create(['name' => 'Aman Verma', 'about' => 'Famous for his night ghazals.']);
        $author3 = Author::create(['name' => 'Ravi Sharma', 'about' => 'Historical fiction writer.']);

        // 4. Create Categories
        $catFiction = Category::create(['name' => 'Literature & Fiction', 'slug' => Str::slug('Literature & Fiction')]);
        $catPoetry = Category::create(['name' => 'Poetry & Ghazals', 'slug' => Str::slug('Poetry & Ghazals')]);
        $catHistory = Category::create(['name' => 'History & Culture', 'slug' => Str::slug('History & Culture')]);

        // 5. Create Books (Jo humne shop/cart UI mein banayi thi)
        Book::create([
            'publisher_id' => $publisher->id,
            'author_id' => $author1->id,
            'category_id' => $catFiction->id,
            'title' => 'The Art of Storytelling',
            'isbn_13' => '978-3-16-148410-0',
            'binding' => 'Paperback',
            'mrp' => 399.00,
            'price' => 299.00,
            'quantity' => 50,
            'description' => 'A masterpiece on how to weave engaging stories that captivate the mind.',
            'is_exclusive' => false,
            'is_active' => true,
        ]);

        Book::create([
            'publisher_id' => $publisher->id,
            'author_id' => $author2->id,
            'category_id' => $catPoetry->id,
            'title' => 'Ghazals of the Night',
            'isbn_13' => '978-1-23-456789-0',
            'binding' => 'Hardbound',
            'mrp' => 299.00,
            'price' => 199.00,
            'quantity' => 30,
            'description' => 'A beautiful collection of ghazals written in the silence of the night.',
            'is_exclusive' => false,
            'is_active' => true,
        ]);

        Book::create([
            'publisher_id' => $publisher->id,
            'author_id' => $author1->id, // Let's say Ved Prakash is also a Divyansh Exclusive author
            'category_id' => $catFiction->id,
            'title' => 'The Hidden Truth',
            'isbn_13' => '978-0-98-765432-1',
            'binding' => 'Paperback',
            'mrp' => 699.00,
            'price' => 499.00,
            'quantity' => 20,
            'description' => 'An exclusive thrill ride available only on Divyansh Publication.',
            'is_exclusive' => true, // EXCLUSIVE BOOK
            'is_active' => true,
        ]);

        Book::create([
            'publisher_id' => $publisher->id,
            'author_id' => $author3->id,
            'category_id' => $catHistory->id,
            'title' => 'Echoes of the Past',
            'isbn_13' => '978-5-55-555555-5',
            'binding' => 'Paperback',
            'mrp' => 450.00,
            'price' => 350.00,
            'quantity' => 15,
            'description' => 'A deep dive into the historical events that shaped our culture.',
            'is_exclusive' => false,
            'is_active' => true,
        ]);
        
        $this->command->info('Database seeded successfully with dummy E-commerce data! 🚀');
    }
}