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

    // Obtiene asignaturas por el ID del curso
    public function getSubjectsByCourseId(int $courseId): array
    {
        return $this->subjectRepository->findByCourseId($courseId);
    }

    // Crea una nueva asignatura asociada a un curso
    public function createSubject(string $name, int $courseId): void
    {
        if ($this->subjectRepository->existsByNameAndCourse($name, $courseId)) {
            throw new \InvalidArgumentException("La asignatura '{$name}' ya existe para este curso.");
        }
    
        $this->subjectRepository->save($name, $courseId);
    }
    

    public function getAllSubjects(): array
{
    return $this->subjectRepository->findAll();
}

}
