<?php

namespace App\School\Entities;

use App\School\Entities\Department;
use App\School\Trait\Timestampable;

class Teacher extends User
{
    use Timestampable;


    protected ?string $departmentName = null;

    public function __construct($firstName, $lastName, $email, $password, $dni) {

        parent::__construct($firstName, $lastName,  $email, $password, $dni);
        $this->updateTimestamps();
    }

 public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(?string $name): void
    {
        $this->departmentName = $name;
    }
}
