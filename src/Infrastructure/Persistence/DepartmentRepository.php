<?php

namespace App\Infrastructure\Persistence;

use App\School\Entities\Department;
use App\School\Repositories\IDepartmentRepository;


class DepartmentRepository implements IDepartmentRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Devuelve todos los departamentos
    public function findAll(): array {
        $query = "SELECT id, name FROM departments";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $departments = [];
        while ($row = $stmt->fetch()) {
            $departments[] = new Department($row['id'], $row['name']);
        }

        return $departments;
    }

    // Asigna un departamento a un profesor
    function assignDepartment($teacherId, $departmentId): void {
        $query="UPDATE teachers SET department_id = :department_id WHERE id = :teacher_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':department_id', $departmentId); 
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->execute();
    }
    
    // Guarda un nuevo departamento
    function save(Department $department): void {
        $query="INSERT INTO departments(name) VALUES(:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $department->getName());
        $stmt->execute();
    }
}