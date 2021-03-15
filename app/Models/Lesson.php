<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
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

    public function courses()
    {
        return $this->belongsToMany(Course::class,'courses_lessons');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class,'lessons_levels');
    }

}
