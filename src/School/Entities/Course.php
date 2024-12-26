<?php 

    namespace App\School\Entities;
    use App\School\Entities\Subject;

    class Course{
        protected $name;
        protected ?int $id = null;  
        protected $subjects=[];

        function __construct(string $name, int $id){
            $this->name=$name;
            $this->id=$id;
        }

        function addSubject(Subject $subject){
            $this->subjects[]=$subject;
            return $this;
        }

        function getName(){
            return $this->name;
        }

        function getID(){
            return $this->id;
        }
    }