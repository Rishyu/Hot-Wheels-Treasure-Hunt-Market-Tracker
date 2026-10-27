<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_submissions', function (Blueprint $table) {
            // Unique pricing ID.
            $table->id();

            // Every pricing submission belongs to a car.
            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            // User-submitted pricing belongs to a collector.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('price', 10, 2);

            $table->string('currency', 3);

            // Example: curated or user-submitted.
            $table->string('source_type');

            $table->date('submission_date');

            // Collector submissions begin pending approval.
            $table->string('status')
                ->default('Pending Approval');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_submissions');
    }
};