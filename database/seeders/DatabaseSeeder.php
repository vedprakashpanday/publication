<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ek Admin User Create Karein
        User::create([
            'name' => 'Admin Divyansh',
            'email' => 'admin@divyansh.com',
            'password' => Hash::make('password123'), // Default password
            'role' => 'admin'
        ]);

        // 2. Do Dummy Publishers Create Karein
        Publisher::create([
            'name' => 'Divyansh Publication', 
            'address' => 'Delhi, India',
            'contact_no' => '9876543210'
        ]);
        
        Publisher::create([
            'name' => 'Rajkamal Prakashan', 
            'address' => 'New Delhi, India',
            'contact_no' => '9123456780'
        ]);

        // 3. Do Dummy Authors Create Karein
        Author::create([
            'name' => 'Munshi Premchand', 
            'about' => 'Upanyas Samrat', 
            'famous_works' => 'Godan, Gaban, Karmabhoomi'
        ]);
        
        Author::create([
            'name' => 'Ramdhari Singh Dinkar', 
            'about' => 'Rashtrakavi of India', 
            'famous_works' => 'Rashmirathi, Kurukshetra'
        ]);
    }
}