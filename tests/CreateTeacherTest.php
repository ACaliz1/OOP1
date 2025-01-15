<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\TeacherService;
use App\Infrastructure\Persistence\TeacherRepository;
use App\School\Entities\Teacher;

class CreateTeacherTest extends TestCase
{
    public function testCreateTeacher()
    {
        // Creo un mock del repositorio de profesores porque no quiero realmente guardar nada en la base de datos.
        $teacherRepository = $this->createMock(TeacherRepository::class);

        // Configuro el mock para asegurarme de que el método 'save' se llama correctamente.
        $teacherRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Teacher $teacher) {
                // Compruebo que los datos que recibe el método son los esperados.
                return $teacher->getFirstName() === 'María' &&
                       $teacher->getLastName() === 'López' &&
                       $teacher->getEmail() === 'maria.lopez@example.com' &&
                       $teacher->getDni() === '98765432Z';
            }));

        // Instancio el servicio pasándole el mock del repositorio.
        $teacherService = new TeacherService($teacherRepository);

        // Llamo al método que quiero probar, usando datos de ejemplo.
        $teacher = $teacherService->createTeacher(
            'María',
            'López',
            'maria.lopez@example.com',
            'securepassword',
            '98765432Z'
        );

        // Compruebo que el objeto devuelto tiene los valores correctos.
        $this->assertEquals('María', $teacher->getFirstName());
        $this->assertEquals('López', $teacher->getLastName());
        $this->assertEquals('maria.lopez@example.com', $teacher->getEmail());
        $this->assertEquals('98765432Z', $teacher->getDni());
    }
}
