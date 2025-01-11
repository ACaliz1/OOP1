<?php

namespace App\School\Entities;

use App\School\Entities\User;
use App\School\Trait\Timestampable;

class Student extends User
{
    use Timestampable;

    protected ?int $studentId = null; // Añadir una propiedad específica para student_id
    protected ?string $courseName = null;
    protected $enrollments = [];

    public function __construct($firstName, $lastName, $email, $password, $dni)
    {
        parent::__construct($firstName, $lastName, $email, $password, $dni);
        $this->updateTimestamps();
    }

    public function setCourseName(?string $courseName): void
    {
        $this->courseName = $courseName;
    }

    public function getCourseName(): ?string
    {
        return $this->courseName;
    }

    // Métodos para manejar student_id
    public function setStudentId(int $studentId): void
    {
        $this->studentId = $studentId;
    }

    public function getStudentId(): int
    {
        return $this->studentId; // Devuelve el student_id específico
    }
}
