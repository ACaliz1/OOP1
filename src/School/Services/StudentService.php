<?php

namespace App\School\Services;

use App\School\Entities\Student;
use App\Infrastructure\Persistence\StudentRepository;

class StudentService{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository) {
        $this->studentRepository = $studentRepository;
    }

    // Crear un nuevo estudiante
    public function createStudent(string $firstName, string $lastName, string $email, string $password, string $dni): Student {
        // Validaciones
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($dni)) {
            throw new \InvalidArgumentException("Todos los campos son obligatorios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El email no es válido.");
        }

        if (strlen($dni) < 8) {
            throw new \InvalidArgumentException("El DNI debe tener al menos 8 caracteres.");
        }

        $student = new Student($firstName, $lastName, $email, $password, $dni);

        $this->studentRepository->save($student);

        return $student;
    }

    public function getAllStudents(): array {
        return $this->studentRepository->findAll();
    }

}