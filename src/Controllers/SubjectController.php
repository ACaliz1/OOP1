<?php

namespace App\Controllers;

use App\School\Services\SubjectService;
use App\School\Services\CourseService;

class SubjectController
{
    private SubjectService $subjectService;
    private CourseService $courseService;

    public function __construct()
    {

        $this->subjectService = new SubjectService();
        $this->courseService = new CourseService();
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
            $courseId = $_POST['course_id_to_create'];
    
            $this->subjectService->createSubject($name, $courseId);
    
            header('Location: /courses?successSubject=1');
        } catch (\InvalidArgumentException $e) {
            header('Location: /courses?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
}
