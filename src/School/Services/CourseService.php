<?php

namespace App\School\Services;

use App\School\Entities\Course;
use App\Infrastructure\Persistence\CourseRepository;

class CourseService
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function createCourse(string $name): Course
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("El nombre del curso es obligatorio.");
        }

        $course = new Course($name);

        $this->courseRepository->save($course);

        return $course;
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->findAll();
    }
}