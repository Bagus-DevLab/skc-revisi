<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'status',
        'last_accessed_at',
        'completed_lessons',
    ];

    protected function casts(): array
    {
        return [
            'completed_lessons' => 'array',
            'last_accessed_at' => 'datetime',
        ];
    }

    // Relasi ke User (Opsional tapi sangat disarankan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
