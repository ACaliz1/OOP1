<?php

namespace App\School\Services;

use App\School\Entities\Course;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\SubjectRepository;
use App\Infrastructure\Database\DatabaseConnection;

class CourseService
{
    private CourseRepository $courseRepository;
    private StudentRepository $studentRepository;
    private SubjectRepository $subjectRepository;

    public function __construct(
    ) {
        $db = DatabaseConnection::getConnection();
        $courseRepository = new CourseRepository($db);
        $this->courseRepository = $courseRepository;
    }

    // Crear un nuevo curso
    public function createCourse(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre del curso es obligatorio.");
        }

        // Crear un objeto Course
        $course = new Course($name, null);

        // Pasarlo al repositorio
        $this->courseRepository->save($course);
    }

    // Obtener todos los cursos
    public function getAllCourses(): array
    {
        return $this->courseRepository->findAll();
    }
    
}
