<?php

namespace App\Controllers;

use App\School\Services\EnrollmentService;
use App\School\Services\SubjectService;
use App\School\Services\CourseService;
use App\School\Services\StudentService;

class EnrollmentController
{
    private EnrollmentService $enrollmentService;
    private SubjectService $subjectService;
    private CourseService $courseService;
    private StudentService $studentService;

    public function __construct()
    {                
        // Crear servicios utilizando los repositorios
        $this->subjectService = new SubjectService();
        $this->courseService = new CourseService();
        $this->studentService = new StudentService();
        $this->enrollmentService = new EnrollmentService();
        }

    // Asignar un estudiante a un curso
    public function receivePostAndAssignWithCourseService()
    {
        $courseId = $_POST['course_id'];
        $studentId = $_POST['student_id'];

        $this->enrollmentService->assignStudentToCourse($courseId, $studentId);

        header('Location: /courses?CourseAssign=1');
        exit;
    }

    public function showData()
    {
        // Obtener info
        $courses = $this->courseService->getAllCourses();
        $subjects = $this->subjectService->getAllSubjects();
        $students = $this->studentService->getAllStudents();

        // Cargar la vista de asignaturas
        echo view('courses', [
            'subjects' => $subjects,
            'courses' => $courses,
            'students' => $students,
        ]);
    }
}