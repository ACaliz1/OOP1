<?php

namespace App\School\Services;

use App\Infrastructure\Persistence\DepartmentRepository;
use App\School\Entities\Department;
use App\Infrastructure\Database\DatabaseConnection;

class DepartmentService
{
    private DepartmentRepository $departmentRepository;

    public function __construct()
    {
        $db=DatabaseConnection::getConnection();
        $departmentRepository = new DepartmentRepository($db);
        $this->departmentRepository = $departmentRepository;
    }

    // Crea un nuevo departamento
    public function createDepartment(string $name): Department
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre del departamento no puede estar vacío.");
        }
        $department = new Department(null, $name);

        $this->departmentRepository->save($department);

        return $department;
    }

    // Obtiene todos los departamentos
    public function getAllDepartments(): array
    {
        return $this->departmentRepository->findAll();
    }

    // Asigna un departamento a un profesor
    public function callToAssignDepartment($teacherId, $departmentId): void
    {
        $this->departmentRepository->assignDepartment($teacherId, $departmentId);
    }
}
