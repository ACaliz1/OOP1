<?php

namespace App\Controllers;

use App\School\Services\CourseService;

class CourseController
{
    private CourseService $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService();
    }

    public function receivePostAndSendToCourseService()
    {
        $name = $_POST['name'];
    
        // Llamar al servicio para crear el curso
        $this->courseService->createCourse($name);
    
        header('Location: /courses?successCourse=1');
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
