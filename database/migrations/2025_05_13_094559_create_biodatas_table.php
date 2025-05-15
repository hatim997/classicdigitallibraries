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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->string('namaSiswa')->nullable();
            $table->string('episode')->nullable();
            $table->integer('is_new')->nullable();
            $table->string('folder')->nullable();
            $table->foreignId('sub_course_id ')->nullable()->constrained('subcourses')->nullOnDelete();
            $table->string('audio')->nullable();
            $table->foreignId('course_id ')->nullable()->constrained('courses')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
