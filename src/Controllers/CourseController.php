<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\SubjectRepository;
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
    
        // Llamar al servicio para crear el curso
        $this->courseService->createCourse($name);
    
        header('Location: /course?successCourse=1');
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
