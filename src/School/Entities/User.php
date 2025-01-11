<?php

namespace App\School\Entities;

class User
{
    protected string $first_name;
    protected string $last_name;
 
    private string $email;
    private string $password;
    private string $dni;

    // Los campos id, createdAt y updatedAt son establecidos automáticamente por la base de datos
    private ?int $id = null;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    // El uuid es establecido automáticamente por el repositorio
    private string $uuid;


    public function __construct($firstName, $lastName, $email, $password, $dni)
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->dni = $dni;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function getLastName() : string
    {
        return $this->last_name;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDni(): string
    {
        return $this->dni;
    }
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
