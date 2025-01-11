<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\SubjectRepository;
use App\School\Services\CourseService;
use App\School\Services\StudentService;

class StudentController
{
    private CourseService $courseService;
    private StudentService $studentService;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();
        $courseRepository = new CourseRepository($db);
        $studentRepository = new StudentRepository($db);
        $subjectRepository = new SubjectRepository($db);

        $this->courseService = new CourseService($courseRepository, $studentRepository, $subjectRepository);
        $this->studentService = new StudentService($studentRepository);
    }

    public function receivePostAndSendToStudentService()
    {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dni = $_POST['dni'];

        $this->studentService->createStudent($firstName, $lastName, $email, $password, $dni);

        header('Location: /student?success=1');
        exit;
    }

    public function showData()
    {
        $students = $this->studentService->getAllStudents(); // Incluye el curso si es posible
        $courses = $this->courseService->getAllCourses();
    
        echo view('students', [
            'students' => $students,
            'courses' => $courses,
        ]);
    }
    

}
