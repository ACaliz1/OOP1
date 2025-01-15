<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\SubjectRepository;
use App\School\Services\SubjectService;

class CreateSubjectTest extends TestCase
{
    public function testCreateSubject()
    {
        // Crear mock 
        $subjectRepository = $this->createMock(SubjectRepository::class);

        // Configurar
        $subjectRepository->expects($this->once())
            ->method('existsByNameAndCourse')
            ->with('Matemáticas', 1)
            ->willReturn(false);

        $subjectRepository->expects($this->once())
            ->method('save')
            ->with('Matemáticas', 1);

        // Crear el servicio con el mock
        $subjectService = new SubjectService($subjectRepository);

        // Ejecutar el caso de uso
        $subjectService->createSubject('Matemáticas', 1);
    }

    public function testCreateSubjectDuplicate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("La asignatura 'Matemáticas' ya existe para este curso.");

        // Crear mock
        $subjectRepository = $this->createMock(SubjectRepository::class);

        // Configurar
        $subjectRepository->expects($this->once())
            ->method('existsByNameAndCourse')
            ->with('Matemáticas', 1)
            ->willReturn(true);

        $subjectRepository->expects($this->never())
            ->method('save');

        // Crear el servicio con el mock
        $subjectService = new SubjectService($subjectRepository);

        $subjectService->createSubject('Matemáticas', 1);
    }
}
