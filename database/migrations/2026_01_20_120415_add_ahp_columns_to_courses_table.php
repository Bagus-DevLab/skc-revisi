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
            Schema::table('courses', function (Blueprint $table) {
                $table->decimal('rating', 3, 2)->default(0); // C2: Rating (contoh 4.50)
                $table->integer('students_count')->default(0); // C3: Peminat
                $table->enum('difficulty_level', ['1', '2', '3', '4', '5'])->default('3'); // C5: Kesulitan (1=Mudah, 5=Sulit)
            });
        }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
};
