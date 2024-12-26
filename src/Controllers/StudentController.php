<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\CourseRepository;
use App\School\Services\StudentService;
use App\School\Services\CourseService;

class StudentController{
    private StudentService $studentService;
    private CourseService $courseService;
    private StudentRepository $studentRepository;
    private CourseRepository $courseRepository;


    public function __construct(){
        $db = DatabaseConnection::getConnection();
        $this->studentRepository = new StudentRepository($db);
        $this->studentService = new StudentService($this->studentRepository);
        $this->courseRepository = new CourseRepository($db);
        $this->courseService = new CourseService($this->courseRepository);
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
        $students = $this->studentService->getAllStudents();
        $courses = $this->courseService->getAllCourses();
        echo view('students', [
            'students' => $students,
            'courses' => $courses
            // 'departments' => $departments,
        ]);
    }

}