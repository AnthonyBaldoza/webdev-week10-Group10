<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 3 venues
        $venues = collect([
            ['name' => 'Main Auditorium', 'address' => 'Admin Building, Ground Floor', 'capacity' => 500],
            ['name' => 'Gymnasium', 'address' => 'Sports Complex', 'capacity' => 800],
            ['name' => 'Function Hall', 'address' => 'Student Center, 2nd Floor', 'capacity' => 150],
        ])->map(fn ($v) => Venue::create($v));

        // 6 events, created through the venue relationship
        $events = collect([
            [0, 'Freshmen Orientation', '2026-11-10 09:00:00'],
            [0, 'Tech Talk: Intro to Laravel', '2026-11-12 14:00:00'],
            [1, 'Intramurals Opening', '2026-11-15 08:00:00'],
            [1, 'Chess Tournament', '2026-11-18 09:00:00'],
            [2, 'Career Fair', '2026-11-20 10:00:00'],
            [2, 'Research Colloquium', '2026-11-25 13:00:00'],
        ])->map(fn ($e) => $venues[$e[0]]->events()->create([
            'title' => $e[1],
            'starts_at' => $e[2],
        ]));

        // 8 participants
        $participants = collect([
            ['Juan Dela Cruz', 'juan@example.com'],
            ['Maria Santos', 'maria@example.com'],
            ['Pedro Reyes', 'pedro@example.com'],
            ['Ana Garcia', 'ana@example.com'],
            ['Jose Ramos', 'jose@example.com'],
            ['Liza Mendoza', 'liza@example.com'],
            ['Carlo Bautista', 'carlo@example.com'],
            ['Rhea Villanueva', 'rhea@example.com'],
        ])->map(fn ($p) => Participant::create(['name' => $p[0], 'email' => $p[1]]));

        // 12 registrations (event index, participant index, status)
        $registrations = [
            [0, 0, 'registered'], [0, 1, 'registered'], [0, 2, 'waitlisted'],
            [1, 0, 'registered'], [1, 3, 'registered'],
            [2, 4, 'waitlisted'], [2, 5, 'registered'],
            [3, 6, 'registered'], [3, 7, 'registered'],
            [4, 1, 'registered'], [4, 2, 'registered'],
            [5, 3, 'waitlisted'],
        ];

        foreach ($registrations as [$e, $p, $status]) {
            $events[$e]->participants()->attach($participants[$p]->id, ['status' => $status]);
        }

        // 6 notes: 3 on events, 3 on venues
        $events[0]->notes()->create(['body' => 'Bring a valid school ID.']);
        $events[3]->notes()->create(['body' => 'Bring your own chess clock.']);
        $events[4]->notes()->create(['body' => 'Company booths open at 10 AM.']);

        $venues[0]->notes()->create(['body' => 'Projector needs a 15-minute warm-up.']);
        $venues[1]->notes()->create(['body' => 'No outside food allowed.']);
        $venues[2]->notes()->create(['body' => 'Air conditioning is available.']);
    }
}