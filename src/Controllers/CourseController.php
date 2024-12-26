<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\School\Services\CourseService;
use App\Infrastructure\Persistence\CourseRepository;

class CourseController
{
    private CourseService $courseService;
    private CourseRepository $courseRepository;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();
        $this->courseRepository = new CourseRepository($db);
        $this->courseService = new CourseService($this->courseRepository);
    }

    public function receivePostAndSendToCourseService()
    {
        $name = $_POST['name'];

        $this->courseService->createCourse($name);

        header('Location: /student?successCourse=1');
        exit;
    }

    public function showData()
    {
        $courses = $this->courseService->getAllCourses();
        var_dump($courses);
        echo view('courses', [
            'courses' => $courses,
        ]);
    }
}