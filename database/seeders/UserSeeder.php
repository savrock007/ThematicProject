<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Alexander',
                'role' => 'admin',
                'email' => 'savrock82@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => '$2y$12$J6zm8gJ0Ft6G7qF1ejxzMOTCtQQcaAdpU7rRBpY84nxZTNCRcNWi6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
