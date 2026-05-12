<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // siswa
            $table->foreignId('assessor_id')->constrained('users')->cascadeOnDelete(); // guru/pembimbing
            $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete();
            $table->decimal('soft_skill_score', 5, 2)->default(0);
            $table->decimal('hard_skill_score', 5, 2)->default(0);
            $table->decimal('discipline_score', 5, 2)->default(0);
            $table->decimal('attitude_score', 5, 2)->default(0);
            $table->decimal('total_score', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'assessor_id', 'period_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
