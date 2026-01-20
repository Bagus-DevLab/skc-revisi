<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
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
}
