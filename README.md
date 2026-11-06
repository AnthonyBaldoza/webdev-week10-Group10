# Campus Events (Week 10)

Laravel + PostgreSQL data layer for a small Campus Events system: venues host events, participants register for events, and notes attach to either an event or a venue.

## Setup

1. `composer install`
2. Copy `.env.example` to `.env`, set the PostgreSQL credentials, then run `php artisan key:generate`
3. `php artisan migrate:fresh --seed`
4. `php artisan serve` and open `/report`

## Relationships

| Link                  | Type                                                    | Model/table holding the FK                                                       | Relationship methods                                   | ON DELETE              | Reason                                                                                                                                                             |
| --------------------- | ------------------------------------------------------- | -------------------------------------------------------------------------------- | ------------------------------------------------------ | ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Venue and Event       | One-to-many                                             | `events.venue_id`                                                                | `Venue::events()`, `Event::venue()`                    | RESTRICT               | A venue that still has events must not be deletable.                                                                                                               |
| Event and Participant | Many-to-many (pivot `event_participant`, with `status`) | `event_participant.event_id` and `event_participant.participant_id`              | `Event::participants()`, `Participant::events()`       | CASCADE (both FKs)     | A registration has no meaning once its event or participant is gone.                                                                                               |
| Note and Event/Venue  | Polymorphic one-to-many                                 | `notes.noteable_type` + `notes.noteable_id` on the `Note` model (no database FK) | `Event::notes()`, `Venue::notes()`, `Note::noteable()` | None (not enforceable) | A single `noteable_id` column cannot be a foreign key to both events and venues, so PostgreSQL cannot validate it; only application code can keep this link valid. |
