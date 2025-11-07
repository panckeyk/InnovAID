<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a primary Admin user
        User::create([
            'id' => Str::uuid(),
            'firstname' => 'System', 
            'lastname' => 'Admin',   
            'email' => 'admin@innovaid.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'verified' => true,
        ]);
        
        // 2. Create a specific Student user (Campaign Creator)
        User::create([
            'id' => Str::uuid(),
            'firstname' => 'Project', 
            'lastname' => 'Student',   
            'email' => 'student@innovaid.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'S1234567',
            'department' => 'IT',
            'email_verified_at' => now(),
            'verified' => true,
        ]);
        
        // 3. Create a specific Donor user
        User::create([
            'id' => Str::uuid(),
            'firstname' => 'Generous', 
            'lastname' => 'Donor',    
            'email' => 'donor@innovaid.com',
            'password' => Hash::make('password'),
            'role' => 'donor',
            'email_verified_at' => now(),
            'verified' => true,
        ]);
        
        // 4. Create 5 additional student accounts using the factory
        User::factory(5)->create(['role' => 'student']);

        // 5. Create 10 additional donor accounts using the factory
        User::factory(10)->create(['role' => 'donor']);
    }
}