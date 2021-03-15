<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class,'courses_lessons');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class,'lessons_levels');
    }
}
