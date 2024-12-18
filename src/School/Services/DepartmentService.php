<?php

namespace App\School\Services;

use App\Infrastructure\Persistence\DepartmentRepository;
use App\School\Entities\Department;

class DepartmentService
{
    private DepartmentRepository $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }
    public function createDepartment(string $name): Department
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre del departamento no puede estar vacío.");
        }
        $department = new Department(null, $name);

        $this->departmentRepository->save($department);

        return $department;
    }
    public function getAllDepartments(): array
    {
        return $this->departmentRepository->findAll();
    }

    public function callToAssignDepartment($teacherId, $departmentId): void
    {
        $this->departmentRepository->assignDepartment($teacherId, $departmentId);
    }
}
