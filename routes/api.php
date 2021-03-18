<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(\App\Http\Middleware\EnsureSignatureIsValid::class)->group(function () {

    Route::apiResource('students', \App\Http\Controllers\Api\Students\ApiStudentController::class);
    Route::apiResource('courses', \App\Http\Controllers\Api\Courses\ApiCourseController::class);
    Route::apiResource('lessons', \App\Http\Controllers\Api\Lessons\ApiLessonController::class);
    Route::apiResource('levels',    \App\Http\Controllers\Api\Levels\ApiLevelController::class);
    Route::apiResource('achievements',\App\Http\Controllers\Api\Achievements\ApiAchievementsController::class);
    Route::apiResource('tasks',\App\Http\Controllers\Api\Tasks\TaskApiController::class);
    Route::apiResource('skills',\App\Http\Controllers\Api\Skills\SkillApiController::class);

    Route::post(
        'lesson/addtocourse',
        [\App\Http\Controllers\Api\Lessons\ApiLessonController::class, 'addLessonToCourse']
    );

    Route::post(
        'skills/addtotask',
        [\App\Http\Controllers\Api\Skills\SkillApiController::class, 'addSkillToTask']
    );

    Route::get(
        'tasks/{task}/skills',
        [\App\Http\Controllers\Api\Tasks\TaskApiController::class, 'getTaskSkills']
    );

    Route::post(
        'level/addtocourse',
        [\App\Http\Controllers\Api\Levels\ApiLevelController::class, 'addLevelToCourse']
    );
    Route::post(
        'lesson/addtolevel',
        [\App\Http\Controllers\Api\Lessons\ApiLessonController::class, 'addLessonToLevel']
    );
    Route::post(
        'students/subscribe/course',
        [\App\Http\Controllers\Api\Students\ApiStudentController::class, 'subscribeForCourse']
    );
    Route::get(
        'student/courses',
        [\App\Http\Controllers\Api\Students\ApiStudentController::class, 'getStudentCourses']
    );
    Route::get(
        'course/lessons/{course}',
        [\App\Http\Controllers\Api\Courses\ApiCourseController::class, 'getCourseLessons']
    );
    Route::get(
        'student/courses/finish',
        [\App\Http\Controllers\Api\Students\ApiStudentController::class, 'finishCourse']
    );
});

