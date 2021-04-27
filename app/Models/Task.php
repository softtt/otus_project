<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
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
        'difficulty'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'task_skill')->withPivot(array('percent'));
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Student::class,'student_task')->withPivot(array(
            'is_finished',
            'tries',
            'finish_until',
            'mark'
        ));
    }
}
