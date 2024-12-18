<?php 

namespace App\School\Repositories;

use App\School\Entities\Teacher;
use App\School\Entities\Department;

interface ITeacherRepository {
    public function save(Teacher $teacher): void;
    public function findById($id): ?Teacher;
    public function findAll(): array;
}
