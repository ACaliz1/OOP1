<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\CourseRepository;
use App\School\Services\CourseService;

class CourseController
{
    private CourseService $courseService;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();
        $courseRepository = new CourseRepository($db);

        $this->courseService = new CourseService($courseRepository);
    }

    public function receivePostAndSendToCourseService()
    {
        $name = $_POST['name'];
    
        try {
            $this->courseService->createCourse($name);
            header('Location: /courses?successCourse=1');
        } catch (\InvalidArgumentException $e) {
            header('Location: /courses?error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    // Mostrar datos
    public function showData()
    {
        $courses = $this->courseService->getAllCourses();
        echo view('courses', [
            'courses' => $courses,
        ]);
    }
}
