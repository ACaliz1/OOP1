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
        $query = "INSERT INTO courses (name, degree_id) VALUES (:name, :degree_id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'name' => $course->getName(),
            'degree_id' => 2 // Puedes parametrizar este valor si es necesario
        ]);
    }
    

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
    

    public function assignStudentToCourse(int $courseId, int $studentId): void
    {
        // Encuentra un subject_id relacionado con el course_id
        $querySubject = "SELECT id FROM subjects WHERE course_id = :course_id LIMIT 1";
        $stmt = $this->db->prepare($querySubject);
        $stmt->execute(['course_id' => $courseId]);
        $subjectId = $stmt->fetchColumn();
    
        if (!$subjectId) {
            throw new \InvalidArgumentException("No se encontró una asignatura asociada al curso con ID $courseId.");
        }
    
        // Inserta en enrollments con student_id y subject_id
        $query = "INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (:student_id, :subject_id, CURDATE())";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'student_id' => $studentId,
            'subject_id' => $subjectId
        ]);
    }
    
    public function assignStudentToSubject(int $studentId, int $subjectId): void
{
    $query = "INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (:student_id, :subject_id, :enrollment_date)";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        'student_id' => $studentId,
        'subject_id' => $subjectId,
        'enrollment_date' => date('Y-m-d')
    ]);
}

    

    public function exists(int $courseId): bool
{
    $query = "SELECT COUNT(*) FROM courses WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $courseId]);
    return $stmt->fetchColumn() > 0;
}

}