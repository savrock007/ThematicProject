<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'title' => 'New',
            ],
            [
                'title' => 'In progress',

            ],
            [
                'title' => 'Testing',
            ],
            [
                'title' => 'Done',
            ],
        ]);
    }
}
