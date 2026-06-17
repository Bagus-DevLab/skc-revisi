<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->json('completed_lessons')->nullable()->after('last_accessed_at');
        });

        $duplicates = DB::table('enrollments')
            ->select('user_id', 'course_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('user_id', 'course_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('enrollments')
                ->where('user_id', $duplicate->user_id)
                ->where('course_id', $duplicate->course_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('enrollments', function (Blueprint $table) {
            $table->unique(['user_id', 'course_id'], 'enrollments_user_course_unique');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique('enrollments_user_course_unique');
            $table->dropColumn('completed_lessons');
        });
    }
};
