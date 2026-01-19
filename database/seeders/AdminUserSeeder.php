<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@rto.gov.in',
            'phone' => '9999999999',
            'password' => bcrypt('admin123'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        // Create Regular Admin
        \App\Models\User::create([
            'name' => 'RTO Admin',
            'email' => 'rtoadmin@rto.gov.in',
            'phone' => '9999999998',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        echo "Admin users created successfully!\n";
        echo "Super Admin: admin@rto.gov.in / admin123\n";
        echo "Admin: rtoadmin@rto.gov.in / admin123\n";
    }
}
