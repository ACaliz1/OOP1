<?php 

    namespace App\School\Entities;

    class Department {
        protected ?int $id = null;        
        private $name;
    
        public function __construct($id, $name) {
            $this->id = $id;
            $this->name = $name;
        }
    
        public function getId(): string {
            return $this->id;
        }
    
        public function getName(): string {
            return $this->name;
        }
    }