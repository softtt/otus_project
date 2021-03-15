<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    public function test()
    {
        $student = new Student();
        $student->firstname = 'Vitaliy';
        $student->lastname = 'Sheinin';
        $student->email = 'vitaliy.sheynin@mail.ru';
        $student->study_begins_date = Carbon::now();
        $student->birthday = Carbon::now();
        //$student->save();


        //dd($student);
       // $student = Student::all()->first();
        return array('data' => $student);
    }
}
