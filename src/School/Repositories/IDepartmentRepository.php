<?php

namespace App\School\Repositories;

use App\School\Entities\Department;

interface IDepartmentRepository {
    public function findAll(): array;
    public function assignDepartment($teacherId, $departmentId): void;
}
