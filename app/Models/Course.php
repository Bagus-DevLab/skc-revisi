<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'price',
        'duration',
        'description',
        'image',
        'rating',           // Kriteria C2
        'students_count',   // Kriteria C3
        'difficulty_level'  // Kriteria C5
    ];

    public function students()
{
    return $this->belongsToMany(User::class, 'enrollments')
                ->withPivot('progress', 'status', 'last_accessed_at')
                ->withTimestamps();
}

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
