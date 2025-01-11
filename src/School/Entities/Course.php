<?php 

namespace App\School\Entities;

class Course
{
    protected $name;
    protected ?int $id = null;  
    protected $subjects = [];

    public function __construct(string $name, ?int $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function addSubject(Subject $subject)
    {
        $this->subjects[] = $subject;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getID(): ?int
    {
        return $this->id;
    }
}
