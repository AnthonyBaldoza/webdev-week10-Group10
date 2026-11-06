<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_participant', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('registered');
            $table->timestamps();

            $table->primary(['event_id', 'participant_id']);
        });

        DB::statement("ALTER TABLE event_participant ADD CONSTRAINT event_participant_status_check CHECK (status IN ('registered', 'waitlisted'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participant');
    }
};