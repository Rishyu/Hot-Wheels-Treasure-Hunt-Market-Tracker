<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id();

            // Administrator who reviewed the submission.
            $table->foreignId('admin_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Pricing submission that was reviewed.
            $table->foreignId('price_submission_id')
                ->constrained('price_submissions')
                ->cascadeOnDelete();

            // approved or rejected
            $table->string('action');

            // Date and time the administrator performed the action.
            $table->timestamp('action_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
};