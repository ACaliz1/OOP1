<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
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

        $this->courseService = new CourseService($courseRepository);
        $this->studentService = new StudentService($studentRepository);
    }

    // Recibe los datos del formulario y crea un nuevo estudiante
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

    // Asignar un estudiante a un curso
    public function showData()
    {
        $students = $this->studentService->getAllStudents();
        $courses = $this->courseService->getAllCourses();
    
        echo view('students', [
            'students' => $students,
            'courses' => $courses,
        ]);
    }
    

}
