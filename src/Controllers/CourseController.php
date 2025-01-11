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
        $studentRepository = new StudentRepository($db);
        $subjectRepository = new SubjectRepository($db);

        $this->courseService = new CourseService($courseRepository, $studentRepository, $subjectRepository);
    }

    public function receivePostAndSendToCourseService()
    {
        $name = $_POST['name'];
    
        // Llamar al servicio para crear el curso
        $this->courseService->createCourse($name);
    
        header('Location: /student?successCourse=1');
        exit;
    }
    

    public function receivePostAndAssignWithCourseService()
    {
        $courseId = $_POST['course_id'];
        $studentId = $_POST['student_id'];

        $this->courseService->assignStudentToCourse($courseId, $studentId);

        header('Location: /student?CourseAssign=1');
        exit;
    }

    public function showData()
    {
        $courses = $this->courseService->getAllCourses();
        echo view('courses', [
            'courses' => $courses,
        ]);
    }
}
