<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('religion', 30);
            $table->foreignId('class_id')->constrained('classes')->restrictOnDelete();
            $table->foreignId('major_id')->constrained('majors')->restrictOnDelete();
            $table->unsignedSmallInteger('entry_year');
            $table->text('address');
            $table->string('phone', 20)->nullable();
            $table->string('parent_name');
            $table->string('parent_phone', 20)->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('photo')->nullable();
            $table->enum('status', ['aktif', 'lulus', 'pindah'])->default('aktif');
            $table->timestamps();

            $table->index('status');
            $table->index('entry_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
