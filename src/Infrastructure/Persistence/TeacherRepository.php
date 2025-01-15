<?php

namespace App\Infrastructure\Persistence;

use App\School\Entities\Teacher;
use App\School\Repositories\ITeacherRepository;

class TeacherRepository implements ITeacherRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Guarda un nuevo profesor
    public function save(Teacher $teacher): void
    {
        $uuid = $this->generateUuid();

        // Insertar en la tabla users
        $query = "INSERT INTO users (uuid, first_name, last_name, email, password, dni, user_type)
                  VALUES (:uuid, :first_name, :last_name, :email, :password, :dni, :user_type)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':first_name', $teacher->getFirstName());
        $stmt->bindParam(':last_name', $teacher->getLastName());
        $stmt->bindParam(':email', $teacher->getEmail());
        $stmt->bindParam(':password', $teacher->getPassword());
        $stmt->bindParam(':dni', $teacher->getDni());

        $userType = 'teacher';
        $stmt->bindParam(':user_type', $userType);

        $stmt->execute();

        // Obtener el ID del usuario recién creado
        $userId = $this->db->lastInsertId();
        $teacher->setId($userId);

        // Insertar en la tabla teachers
        $query = "INSERT INTO teachers (user_id) VALUES (:user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    // Encuentra un profesor por su ID
    public function findById($id): ?Teacher
    {
        $query = "SELECT * FROM teachers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject(Teacher::class) ?: null;
    }

    // Encuentra todos los profesores
    public function findAll(): array {
        $query = "
            SELECT 
                teachers.id AS teacher_id,
                users.first_name,
                users.last_name,
                users.email,
                users.dni,
                departments.name AS department_name
            FROM 
                teachers
            JOIN 
                users ON teachers.user_id = users.id
            LEFT JOIN 
                departments ON teachers.department_id = departments.id
            WHERE 
                users.user_type = 'teacher'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $teachers = [];
    
        foreach ($rows as $row) {
            $teacher = new Teacher(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                '********',
                $row['dni']
            );
            $teacher->setId($row['teacher_id']);
            $teacher->setDepartmentName($row['department_name'] ?? 'Sin Departamento');
            $teachers[] = $teacher;
        }
    
        return $teachers;
    }

    // Genera un UUID
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
}