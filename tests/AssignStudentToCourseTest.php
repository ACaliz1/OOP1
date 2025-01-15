<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\EnrollmentService;
use App\Infrastructure\Persistence\SubjectRepository;
use App\Infrastructure\Persistence\EnrollmentRepository;

class AssignStudentToCourseTest extends TestCase
{
    public function testAssignStudentToCourse()
    {
        // Crear  mocks
        $subjectRepository = $this->createMock(SubjectRepository::class);
        $enrollmentRepository = $this->createMock(EnrollmentRepository::class);

        // Configurar el mock
        $subjectRepository->expects($this->once())
            ->method('findByCourseId')
            ->with(1)
            ->willReturn([
                ['id' => 1, 'name' => 'Matemáticas'],
            ]);

        // Configurar el mock
        $subjectRepository->expects($this->once())
            ->method('existsByIdAndCourse')
            ->with(1, 1)
            ->willReturn(true);

        // Configurar el mock
        $enrollmentRepository->expects($this->once())
            ->method('assignStudentToSubject')
            ->with(2, 1);

        // Crear una instancia del servicio con el repositorio mockeado
        $enrollmentService = new EnrollmentService($subjectRepository, $enrollmentRepository);

        $enrollmentService->assignStudentToCourse(1, 2, 1);
    }
}
