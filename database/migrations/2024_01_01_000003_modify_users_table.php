<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['siswa', 'pembimbing_industri', 'guru_pembimbing', 'admin'])->default('siswa')->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('photo')->nullable()->after('phone');
            $table->string('nisn')->nullable()->after('photo');
            $table->string('kelas')->nullable()->after('nisn');
            $table->string('jurusan')->nullable()->after('kelas');
            $table->string('nip')->nullable()->after('jurusan');
            $table->string('jabatan')->nullable()->after('nip');
            $table->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete()->after('jabatan');
            $table->foreignId('guru_pembimbing_id')->nullable()->constrained('users')->nullOnDelete()->after('industry_id');
            $table->foreignId('pembimbing_industri_id')->nullable()->constrained('users')->nullOnDelete()->after('guru_pembimbing_id');
            $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete()->after('pembimbing_industri_id');
            $table->boolean('is_active')->default(true)->after('period_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropForeign(['guru_pembimbing_id']);
            $table->dropForeign(['pembimbing_industri_id']);
            $table->dropForeign(['period_id']);
            $table->dropColumn([
                'role', 'phone', 'photo', 'nisn', 'kelas', 'jurusan',
                'nip', 'jabatan', 'industry_id', 'guru_pembimbing_id',
                'pembimbing_industri_id', 'period_id', 'is_active'
            ]);
        });
    }
};
