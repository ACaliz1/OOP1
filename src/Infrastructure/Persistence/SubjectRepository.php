<?php

namespace App\Infrastructure\Persistence;

use PDO;

class SubjectRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $query = "
            SELECT 
                s.id AS subject_id, 
                s.name AS subject_name, 
                c.name AS course_name 
            FROM 
                subjects s
            LEFT JOIN 
                courses c ON s.course_id = c.id
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Obtiene todas las asignaturas relacionadas con un curso
    public function findByCourseId(int $courseId): array
    {
        $query = "SELECT id, name FROM subjects WHERE course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guarda una nueva asignatura asociada a un curso
    public function save(string $name, int $courseId): void
    {
        $query = "INSERT INTO subjects (name, course_id) VALUES (:name, :course_id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'name' => $name,
            'course_id' => $courseId,
        ]);
    }

    public function existsByNameAndCourse(string $name, int $courseId): bool
{
    $query = "SELECT COUNT(*) FROM subjects WHERE name = :name AND course_id = :course_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        'name' => $name,
        'course_id' => $courseId,
    ]);
    return $stmt->fetchColumn() > 0;
}

}
