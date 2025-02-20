<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'code' => Admin::getCode(),
            'type' => 'administrator',
            'role_id' => 1,
            'name' => 'Mr. Admin',
            'email' => 'administrator@mail.com',
            'mobile' => '12345679810',
            'password_plain' => '123456',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'image' => null,
            'password' => Hash::make('123456'),
            'status' => 'active',
            'request_status' => 'approved'
        ]);
    }
}
