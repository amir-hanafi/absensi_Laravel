<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('subject');
            $table->text('description');

            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            // contoh: 'billing', 'technical', 'account'

            $table->enum('priority', ['low', 'mid', 'high']);
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
