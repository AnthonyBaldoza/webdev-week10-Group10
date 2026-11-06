<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Campus Events Report</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 15px; color: #222; }
        h1 { margin-bottom: 5px; }
        h2 { margin-top: 35px; border-bottom: 2px solid #444; padding-bottom: 4px; font-size: 18px; }
        table { border-collapse: collapse; width: 100%; margin-top: 8px; }
        th, td { border: 1px solid #bbb; padding: 6px 10px; text-align: left; }
        th { background: #f0f0f0; }
        form { background: #f7f7f7; padding: 12px; border: 1px solid #ddd; display: flex; flex-wrap: wrap; gap: 12px; align-items: end; }
        label { display: flex; flex-direction: column; font-size: 13px; }
        select, button { padding: 5px; }
        .empty { color: #777; font-style: italic; }
    </style>
</head>
<body>
    <h1>Campus Events Report</h1>
    <p>Choose items below, then click Apply.</p>

    <form method="GET" action="{{ route('report') }}">
        <label>Venue
            <select name="venue_id">
                @foreach ($allVenues as $v)
                    <option value="{{ $v->id }}" @selected($v->id === $venue->id)>{{ $v->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Event
            <select name="event_id">
                @foreach ($allEvents as $e)
                    <option value="{{ $e->id }}" @selected($e->id === $event->id)>{{ $e->title }}</option>
                @endforeach
            </select>
        </label>
        <label>Participant
            <select name="participant_id">
                @foreach ($allParticipants as $p)
                    <option value="{{ $p->id }}" @selected($p->id === $participant->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Note
            <select name="note_id">
                @foreach ($allNotes as $n)
                    <option value="{{ $n->id }}" @selected($n->id === $note->id)>Note #{{ $n->id }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Apply</button>
    </form>

    <h2>1. Every venue with the number of events it hosts</h2>
    <table>
        <tr><th>Venue</th><th>Number of events</th></tr>
        @foreach ($venuesWithCount as $v)
            <tr><td>{{ $v->name }}</td><td>{{ $v->events_count }}</td></tr>
        @endforeach
    </table>

    <h2>2. All events at venue: {{ $venue->name }}</h2>
    <table>
        <tr><th>Event</th><th>Starts at</th></tr>
        @forelse ($venueEvents as $e)
            <tr><td>{{ $e->title }}</td><td>{{ $e->starts_at->format('M d, Y h:i A') }}</td></tr>
        @empty
            <tr><td colspan="2" class="empty">No events.</td></tr>
        @endforelse
    </table>

    <h2>3. Participants of event: {{ $event->title }}</h2>
    <table>
        <tr><th>Participant</th><th>Email</th><th>Status</th></tr>
        @forelse ($eventParticipants as $p)
            <tr><td>{{ $p->name }}</td><td>{{ $p->email }}</td><td>{{ $p->pivot->status }}</td></tr>
        @empty
            <tr><td colspan="3" class="empty">No participants.</td></tr>
        @endforelse
    </table>

    <h2>4. Events joined by participant: {{ $participant->name }}</h2>
    <table>
        <tr><th>Event</th><th>Starts at</th><th>Status</th></tr>
        @forelse ($participantEvents as $e)
            <tr><td>{{ $e->title }}</td><td>{{ $e->starts_at->format('M d, Y h:i A') }}</td><td>{{ $e->pivot->status }}</td></tr>
        @empty
            <tr><td colspan="3" class="empty">No events joined.</td></tr>
        @endforelse
    </table>

    <h2>5. Events with at least one waitlisted participant</h2>
    <table>
        <tr><th>Event</th><th>Venue</th></tr>
        @forelse ($waitlistedEvents as $e)
            <tr><td>{{ $e->title }}</td><td>{{ $e->venue->name }}</td></tr>
        @empty
            <tr><td colspan="2" class="empty">None.</td></tr>
        @endforelse
    </table>

    <h2>6a. Notes of event: {{ $event->title }}</h2>
    <table>
        <tr><th>ID</th><th>Note</th></tr>
        @forelse ($eventNotes as $n)
            <tr><td>{{ $n->id }}</td><td>{{ $n->body }}</td></tr>
        @empty
            <tr><td colspan="2" class="empty">No notes.</td></tr>
        @endforelse
    </table>

    <h2>6b. Notes of venue: {{ $venue->name }}</h2>
    <table>
        <tr><th>ID</th><th>Note</th></tr>
        @forelse ($venueNotes as $n)
            <tr><td>{{ $n->id }}</td><td>{{ $n->body }}</td></tr>
        @empty
            <tr><td colspan="2" class="empty">No notes.</td></tr>
        @endforelse
    </table>

    <h2>7. Owner of note #{{ $note->id }}</h2>
    <table>
        <tr><th>Note</th><th>Belongs to</th><th>Kind</th></tr>
        <tr><td>{{ $note->body }}</td><td>{{ $ownerName }}</td><td>{{ $ownerKind }}</td></tr>
    </table>
</body>
</html>