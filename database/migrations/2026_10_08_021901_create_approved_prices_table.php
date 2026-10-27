<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approved_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('price_submission_id')
                ->unique()
                ->constrained('price_submissions')
                ->cascadeOnDelete();

            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price', 10, 2);
            $table->string('currency', 3);
            $table->timestamp('approved_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approved_prices');
    }
};