<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\StudentService;
use App\Infrastructure\Persistence\StudentRepository;
use App\School\Entities\Student;

class CreateStudentTest extends TestCase
{
    public function testCreateStudent()
    {
        // Crear Mock
        $studentRepository = $this->createMock(StudentRepository::class);

        // Simular que esos datos estan dentro de la bbdd
        $studentRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Student $student) {
                return $student->getFirstName() === 'Laura'
                    && $student->getLastName() === 'Martínez'
                    && $student->getEmail() === 'laura.martinez@gmail.com'
                    && $student->getDni() === '87654321B';
            }));

        // Crear el servicio con el mock
        $studentService = new StudentService($studentRepository);

        $student = $studentService->createStudent(
            'Laura',
            'Martínez',
            'laura.martinez@gmail.com',
            'contrasenaSegura123',
            '87654321B'
        );
        // Verificaciones
        $this->assertInstanceOf(Student::class, $student);
        $this->assertEquals('Laura', $student->getFirstName());
        $this->assertEquals('Martínez', $student->getLastName());
        $this->assertEquals('laura.martinez@gmail.com', $student->getEmail());
        $this->assertEquals('87654321B', $student->getDni());
    }
}
