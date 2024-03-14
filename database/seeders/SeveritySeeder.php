<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeveritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('severities')->insert([
            [
                'title' => 'Low',
                'color' => '#00FF00',
            ],
            [
                'title' => 'Medium',
                'color' => '#0000FF',
            ],
            [
                'title' => 'High',
                'color' => '#FF0000',
            ],
        ]);
    }
}
