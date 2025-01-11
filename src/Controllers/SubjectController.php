<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\SubjectRepository;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\School\Services\SubjectService;
use App\School\Services\CourseService;

class SubjectController
{
    private SubjectService $subjectService;
    private CourseService $courseService;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();

        $subjectRepository = new SubjectRepository($db);
        $courseRepository = new CourseRepository($db);
        $studentRepository = new StudentRepository($db); // Crear instancia de StudentRepository

        $this->subjectService = new SubjectService($subjectRepository);
        $this->courseService = new CourseService($courseRepository, $studentRepository, $subjectRepository);
    }

    // Obtener asignaturas por curso
    public function getSubjectsByCourse()
    {
        $courseId = $_GET['course_id'] ?? null;

        if (!$courseId || !is_numeric($courseId)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid course ID']);
            return;
        }

        $subjects = $this->subjectService->getSubjectsByCourseId((int) $courseId);
        echo json_encode($subjects);
    }

    // Crear una nueva asignatura
    public function createSubject()
    {
        try {
            $name = $_POST['subject_name'];
            $courseId = $_POST['course_id'];
    
            $this->subjectService->createSubject($name, $courseId);
    
            header('Location: /course?successSubject=1');
        } catch (\InvalidArgumentException $e) {
            header('Location: /course?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    // Mostrar datos
    public function showData()
    {
        // Obtener asignaturas y cursos
        $subjects = $this->subjectService->getAllSubjects();
        $courses = $this->courseService->getAllCourses();

        // Cargar la vista de asignaturas
        echo view('subjects', [
            'subjects' => $subjects,
            'courses' => $courses,
        ]);
    }
}
