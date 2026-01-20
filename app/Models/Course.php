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
    ];

    public function students()
{
    return $this->belongsToMany(User::class, 'enrollments')
                ->withPivot('progress', 'status', 'last_accessed_at')
                ->withTimestamps();
}
}
