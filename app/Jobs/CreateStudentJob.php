<?php

namespace App\Jobs;

use App\Models\Student;
use App\Services\Api\DTO\StudentDTO;
use App\Services\Api\Translators\StudentTranslator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class CreateStudentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;

    protected $request_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $student, string $requestId)
    {
        $this->student = $student;
        $this->request_id = $requestId;
    }


    public function handle()
    {
        $student = new Student($this->student);
        $student->save();
        return $student->id;
        //set request id in redis
    }
}
