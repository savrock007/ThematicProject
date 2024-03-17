<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Severity;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;


class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::factory()->count(10)
            ->has(Comment::factory()->count(2))
            ->create()
            ->each(function (Ticket $ticket) {
                $ticket->severity_id = Severity::inRandomOrder()->first()->id;
                $ticket->developer_id = User::where('role','developer')->inRandomOrder()->first()->id;
                $ticket->save();
            }
            );
    }
}
