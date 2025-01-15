<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;

use App\Infrastructure\Persistence\EnrollmentRepository;
use App\Infrastructure\Persistence\SubjectRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\CourseRepository;

use App\School\Services\EnrollmentService;
use App\School\Services\SubjectService;
use App\School\Services\CourseService;
use App\School\Services\StudentService;

class EnrollmentController
{
    private EnrollmentService $enrollmentService;
    private SubjectService $subjectService;
    private CourseService $courseService;
    private StudentService $studentService;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();
        
        // Crear repositorios
        $subjectRepository = new SubjectRepository($db);
        $courseRepository = new CourseRepository($db);
        $enrollmentRepository = new EnrollmentRepository($db);
        $studentRepository = new StudentRepository($db);
        
        // Crear servicios utilizando los repositorios
        $this->subjectService = new SubjectService($subjectRepository);
        $this->courseService = new CourseService($courseRepository);
        $this->studentService = new StudentService($studentRepository);
        $this->enrollmentService = new EnrollmentService($subjectRepository, $enrollmentRepository);
        }

    // Asignar un estudiante a un curso
        public function receivePostAndAssignWithCourseService()
        {
            try {
                $courseId = $_POST['course_id'];
                $studentId = $_POST['student_id'];
                $subjectId = $_POST['subject_id'] ?? null;
    
                $this->enrollmentService->assignStudentToCourse($courseId, $studentId, $subjectId);
    
                header('Location: /courses?CourseAssign=1');
            } catch (\Exception $e) {
                header('Location: /courses?error=' . urlencode($e->getMessage()));
            }
            exit;
        }

    public function showData()
    {
        // Obtener info
        $courses = $this->courseService->getAllCourses();
        $subjects = $this->subjectService->getAllSubjects();
        $students = $this->studentService->getAllStudents();

        // Cargar la vista de asignaturas
        echo view('courses', [
            'subjects' => $subjects,
            'courses' => $courses,
            'students' => $students,
        ]);
    }
}