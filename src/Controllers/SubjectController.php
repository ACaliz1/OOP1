<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\SubjectRepository;
use App\School\Services\SubjectService;

class SubjectController
{
    private SubjectService $subjectService;

    public function __construct()
    {
        $db = DatabaseConnection::getConnection();
        $subjectRepository = new SubjectRepository($db);
        $this->subjectService = new SubjectService($subjectRepository);
    }

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
}
