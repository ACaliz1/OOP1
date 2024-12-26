<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Database\DatabaseConnection;
use App\School\Entities\Course;

class CourseRepository
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function save(Course $course): void
    {
        $query = "INSERT INTO courses (name,degree_id) VALUES (:name, :degree_id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'name' => $course->getName(),
            'degree_id' => 2
        ]);
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM courses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $courses = [];
        while ($row = $stmt->fetch()) {
            $courses[] = new Course($row['name'], $row['id']);
        }

        return $courses;
    }
}