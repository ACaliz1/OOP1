<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\CourseRepository;
use App\School\Services\CourseService;
use App\School\Entities\Course;

class CreateCourseTest extends TestCase
{
    public function testCreateCourse()
    {
        $courseRepository = $this->createMock(CourseRepository::class);

        $courseRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Course::class));

        $courseService = new CourseService($courseRepository);

        $courseService->createCourse("Desarrollo Web");
    }
}
