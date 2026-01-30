<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@masar.com'], // إيميل السوبر آدمن
        [
            'name' => 'Super Admin',
            'password' => Hash::make('admin123'), // الباسورد
            'is_super_admin' => true,
        ]
    );
}
}
