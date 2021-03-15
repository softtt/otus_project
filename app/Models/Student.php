<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 * @package App\Models
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $birthday
 * @property string $study_begins_date
 * @property string $email
 *
 */

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'birthday',
        'study_begins_date',
        'email',
    ];

    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class,'courses_students')->withPivot('is_finished');
    }

    public function finishedCourses()
    {
        return $this->belongsToMany(Course::class,'courses_students')->wherePivot('is_finished', true);
    }


}
