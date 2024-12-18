<?php

    namespace App\School\Entities;

    use App\School\Entities\User;
    use App\School\Trait\Timestampable;
    

    class Student extends User {
        use Timestampable;
        protected ?string $courseName = null;
        protected $enrollments=[];
       
        function __construct($firstName, $lastName, $email, $password, $dni){

            parent::__construct($firstName,$lastName, $email, $password, $dni);
            $this->updateTimestamps();
        }
        public function setCourseName(?string $courseName): void
        {
            $this->courseName = $courseName;
        }
    
        public function getCourseName(): ?string
        {
            return $this->courseName;
        }
        

    }