<?php

namespace App\Controllers;

use App\School\Services\DepartmentService;

class DepartmentController{

    private DepartmentService $departmentService;

    public function __construct(){
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

