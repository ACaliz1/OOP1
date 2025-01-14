<?php

namespace App\Controllers;

use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Persistence\DepartmentRepository;
use App\School\Services\DepartmentService;

class DepartmentController{

    private DepartmentService $departmentService;
    private DepartmentRepository $departmentRepository;

    public function __construct(){
        $db = DatabaseConnection::getConnection();
        $this->departmentRepository = new DepartmentRepository($db);
        $this->departmentService = new DepartmentService();
    }

    // Recibe los datos del formulario y crea un nuevo departamento
   public function receiveAndCreateDepartment(){
    $name = $_POST['name'];
    $this->departmentService->createDepartment($name);

    header('Location: /teacher?success=3');
    exit;
   }
}

