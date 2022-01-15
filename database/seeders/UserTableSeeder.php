<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "name" => "Admin",
                "email" => "admin@admin.com ",
                "password" => Hash::make("password"),
                "role" => "admin",
                "status" => true,
                "created_at" => Carbon::now()
            ],
            [
                "name" => "Manager",
                "email" => "manager@manager.com ",
                "password" => Hash::make("password"),
                "role" => "manager",
                "status" => true,
                "created_at" => Carbon::now()
            ],
            [
                "name" => "Staff",
                "email" => "staff@staff.com ",
                "password" => Hash::make("password"),
                "role" => "staff",
                "status" => true,
                "created_at" => Carbon::now()
            ]
        ];

        User::insert($users);
    }
}
