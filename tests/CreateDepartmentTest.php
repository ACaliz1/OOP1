<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\School\Services\DepartmentService;
use App\Infrastructure\Persistence\DepartmentRepository;
use App\School\Entities\Department;

class CreateDepartmentTest extends TestCase
{
    public function testCreateDepartment()
    {
        $departmentRepository = $this->createMock(DepartmentRepository::class);

        $departmentRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Department $department) {
                return $department->getName() === 'Computer Science';
            }));

        $departmentService = new DepartmentService($departmentRepository);

        $department = $departmentService->createDepartment('Computer Science');

        $this->assertInstanceOf(Department::class, $department);
        $this->assertEquals('Computer Science', $department->getName());
    }
}
