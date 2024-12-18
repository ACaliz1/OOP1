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

    public function findAll(): array
    {
        $query = "SELECT id, uuid, first_name, last_name, email, password, dni, created_at, updated_at 
                  FROM users 
                  WHERE user_type = 'student'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        $students = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $student = new Student(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                $row['password'],
                $row['dni']
            );
    
            // Asignar valores adicionales que están en la clase base User
            $student->setId($row['id']);
            $student->setUuid($row['uuid']);
    
            $students[] = $student;
        }
    
        return $students;
    }
    
    

    public function findById($id): ?Student
    {
        $query = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(Student::class) ?: null;
    }

}