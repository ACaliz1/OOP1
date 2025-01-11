<?php

namespace App\School\Services;

use App\Infrastructure\Persistence\SubjectRepository;

class SubjectService
{
    private SubjectRepository $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function getSubjectsByCourseId(int $courseId): array
    {
        return $this->subjectRepository->findByCourseId($courseId);
    }
}
