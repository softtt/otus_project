<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
        'start_date',
    ];


    public function students()
    {
        return $this->belongsToMany(Student::class,'courses_students')->withPivot('is_finished');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class,'courses_lessons');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class,'courses_levels');
    }
}
