<?php

namespace App\Infrastructure\Persistence;


use App\School\Entities\Student;
use App\School\Repositories\IStudentRepository;
use App\Infrastructure\Persistence\TeacherRepository;



class StudentRepository implements IStudentRepository{
    private $db;
    private TeacherRepository $teacherRepository;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Guarda un nuevo estudiante
    public function save(Student $student): void
    {
        $uuid = $this->generateUuid();

        // Insertar en la tabla users
        $query = "INSERT INTO users (uuid, first_name, last_name, email, password, dni, user_type)
                  VALUES (:uuid, :first_name, :last_name, :email, :password, :dni, :user_type)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':first_name', $student->getFirstName());
        $stmt->bindParam(':last_name', $student->getLastName());
        $stmt->bindParam(':email', $student->getEmail());
        $stmt->bindParam(':password', $student->getPassword());
        $stmt->bindParam(':dni', $student->getDni());

        $userType = 'student';
        $stmt->bindParam(':user_type', $userType);

        $stmt->execute();

        // Obtener el ID del usuario recién creado
        $userId = $this->db->lastInsertId();
        $student->setId($userId);

        // Obtener el año actual
        $enrollmentYear = date('Y');

        // Insertar en la tabla students
        $query = "INSERT INTO students (user_id, enrollment_year) VALUES (:user_id, :enrollment_year)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':enrollment_year', $enrollmentYear);
        $stmt->execute();
    }
    
    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // Encuentra todos los estudiantes
    public function findAll(): array
    {
        $query = "
            SELECT 
                u.id AS user_id, 
                s.id AS student_id, 
                u.first_name, 
                u.last_name, 
                u.email, 
                u.dni, 
                GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS course_name
            FROM 
                students s
            JOIN 
                users u ON s.user_id = u.id
            LEFT JOIN 
                enrollments e ON e.student_id = s.id
            LEFT JOIN 
                subjects sub ON e.subject_id = sub.id
            LEFT JOIN 
                courses c ON sub.course_id = c.id
            WHERE 
                u.user_type = 'student'
            GROUP BY 
                u.id, s.id, u.first_name, u.last_name, u.email, u.dni
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        $students = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $student = new Student(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                '',
                $row['dni']
            );
            $student->setStudentId((int)$row['student_id']);
            $student->setId((int)$row['user_id']);
            $student->setCourseName($row['course_name'] ?? 'Sin Curso');
            $students[] = $student;
        }
        return $students;
    }

    // Encuentra un estudiante por su ID
    public function findById($id): ?Student
    {
        $query = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(Student::class) ?: null;
    }

    // Verifica si un estudiante existe por su ID
    public function exists(int $id): bool
    {
        $query = "SELECT COUNT(*) FROM students WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        return $stmt->fetchColumn() > 0;
    }
}