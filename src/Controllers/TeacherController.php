<?php

namespace App\Controllers;

use App\School\Services\DepartmentService;
use App\School\Services\TeacherService;

class TeacherController
{
    private TeacherService $teacherService;
    private DepartmentService $departmentService;

    public function __construct()
    {

        $teacherService = new TeacherService();
        $departmentService = new DepartmentService();

        $this->teacherService = $teacherService;
        $this->departmentService = $departmentService;

    }

    // Recibe los datos del formulario y crea un nuevo profesor
    public function receivePostAndSendToTeacherService()
    {

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dni = $_POST['dni'];

        $this->teacherService->createTeacher($firstName, $lastName, $email, $password, $dni);

        header('Location: /teacher?success=1');
        exit;
    }

    // Mostrar datos
    public function showData()
    {
        $teachers = $this->teacherService->getAllTeachers();
        $departments = $this->departmentService->getAllDepartments();

        echo view('teachers', [
            'teachers' => $teachers,
            'departments' => $departments,
        ]);
    }
    // Asignar un profesor a un departamento
    public function receivePostAndSendToDepartmentService()
    {
        $teacherId = $_POST['teacher_id'];
        $departmentId = $_POST['department_id'];

        $this->departmentService->callToAssignDepartment($teacherId, $departmentId);

        header('Location: /teacher?success=2');
        exit;
    }
}