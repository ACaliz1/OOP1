<?php
    namespace App\School\Entities;

    class Enrollment
    {
        private ?int $id = null;
        private Student $student;
        private Course $course;
        private ?Subject $subject = null;
        private \DateTime $enrollmentDate;
    
        public function __construct(Student $student, Course $course, ?Subject $subject)
        {
            $this->student = $student;
            $this->course = $course;
            $this->subject = $subject;
            $this->enrollmentDate = new \DateTime();
        }
    
        public function getStudent(): Student
        {
            return $this->student;
        }
    
        public function getCourse(): Course
        {
            return $this->course;
        }
    
        public function getSubject(): ?Subject
        {
            return $this->subject;
        }
    
        public function getEnrollmentDate(): \DateTime
        {
            return $this->enrollmentDate;
        }
    }
    