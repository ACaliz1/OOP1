<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\DepartmentService;
use App\Infrastructure\Persistence\DepartmentRepository;

class AssignTeacherToDepartmentTest extends TestCase
{
    public function testAssignTeacherToDepartment()
    {
        // Crear un mock
        $departmentRepository = $this->createMock(DepartmentRepository::class);

        // Configurar el mock
        $departmentRepository->expects($this->once())
            ->method('assignDepartment')
            ->with(
                $this->equalTo(1), // ID del profesor
                $this->equalTo(2)  // ID del departamento
            );

        // Crear una instancia del servicio con el repositorio mockeado
        $departmentService = new DepartmentService($departmentRepository);

        $departmentService->callToAssignDepartment(1, 2);

    }
}
