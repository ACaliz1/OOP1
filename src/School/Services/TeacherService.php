<?php

namespace App\School\Services;

use App\Infrastructure\Persistence\TeacherRepository;
use App\School\Entities\Teacher;

class TeacherService {
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository) {
        $this->teacherRepository = $teacherRepository;
    }

    // Crear un nuevo profesor
    public function createTeacher(string $firstName, string $lastName, string $email, string $password, string $dni): Teacher {
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

        $teacher = new Teacher($firstName, $lastName, $email, $password, $dni);

        $this->teacherRepository->save($teacher);

        return $teacher;
    }

    // Obtener todos los profesores
    public function getAllTeachers(): array {
        return $this->teacherRepository->findAll();
    }
}
