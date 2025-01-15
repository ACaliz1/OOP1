<?php

namespace App\School\Entities;

use App\School\Trait\Timestampable;

class Teacher extends User
{
    use Timestampable;

    protected ?string $departmentName = null;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $dateTime): void
    {
        $this->createdAt = $dateTime;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $dateTime): void
    {
        $this->updatedAt = $dateTime;
    }
}
