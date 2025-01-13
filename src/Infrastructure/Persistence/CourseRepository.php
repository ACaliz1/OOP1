<?php

namespace App\Infrastructure\Persistence;

use App\School\Entities\Course;

class CourseRepository
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    // Guarda un nuevo curso
    public function save(Course $course): void
    {
        $query = "INSERT INTO courses (name, degree_id) VALUES (:name, :degree_id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'name' => $course->getName(),
            'degree_id' => 2 // hardcodeado porque no lo estamos usando aun
        ]);
    }

    // Obtiene todos los cursos
    public function findAll(): array
    {
        $query = "SELECT id, name FROM courses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        $courses = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $courses[] = new Course($row['name'], $row['id']);
        }
    
        return $courses;
    }

    // Encuentra un curso por su ID
    public function findById(int $courseId): ?Course
    {
        $query = "SELECT id, name FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $courseId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? new Course($row['name'], $row['id']) : null;
    }

    // Verifica si un curso existe por su ID
    public function exists(int $courseId): bool
    {
        $query = "SELECT COUNT(*) FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $courseId]);
        return $stmt->fetchColumn() > 0;
    }
}