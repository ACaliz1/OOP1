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

    public function findByCourseId(int $courseId): array
    {
        $query = "SELECT id, name FROM subjects WHERE course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}
