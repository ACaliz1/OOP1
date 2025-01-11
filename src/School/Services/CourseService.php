<?php

namespace App\School\Services;

use App\School\Entities\Course;
use App\Infrastructure\Persistence\CourseRepository;
use App\Infrastructure\Persistence\StudentRepository;
use App\Infrastructure\Persistence\SubjectRepository;

class CourseService
{
    private CourseRepository $courseRepository;
    private StudentRepository $studentRepository;
    private SubjectRepository $subjectRepository;

    public function __construct(
        CourseRepository $courseRepository,
        StudentRepository $studentRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
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

    // Asignar un estudiante a un curso
    public function assignStudentToCourse(int $courseId, int $studentId): void
    {
        $subjects = $this->subjectRepository->findByCourseId($courseId);
        if (empty($subjects)) {
            throw new \InvalidArgumentException("El curso seleccionado no tiene asignaturas.");
        }

        $subjectId = $_POST['subject_id'];
        $this->courseRepository->assignStudentToSubject($studentId, $subjectId);
    }

    // Obtener todos los cursos
    public function getAllCourses(): array
    {
        return $this->courseRepository->findAll();
    }
    
}
