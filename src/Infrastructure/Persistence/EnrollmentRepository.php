<?php

    namespace App\Infrastructure\Persistence;


    use App\School\Entities\Enrollment;
    use App\School\Repositories\IEnrollmentRepository;

    class EnrollmentRepository implements IEnrollmentRepository{
        private \PDO $db;
        function __construct(\PDO $db){
            $this->db=$db;
        }

        // Devuelve todos los departamentos
        function save(Enrollment $enrollment){
            $stmt=$this->db->prepare("INSERT INTO enrollments() VALUES()");
            $stmt->execute([]);
            return $stmt->fetchObject(Enrollment::class);
        }
        
        function findByDni(string $dni){
            $stmt=$this->db->prepare("SELECT * FROM enrollments WHERE dni=:dni");
            $stmt->execute(['dni'=>$dni]);
            return $stmt->fetchObject(Enrollment::class);
        }

            // Asigna un estudiante a un curso, encontrando primero una asignatura relacionada
    public function assignStudentToCourse(int $courseId, int $studentId): void
    {
        // Encuentra una asignatura relacionada con el curso
        $querySubject = "SELECT id FROM subjects WHERE course_id = :course_id LIMIT 1";
        $stmt = $this->db->prepare($querySubject);
        $stmt->execute(['course_id' => $courseId]);
        $subjectId = $stmt->fetchColumn();
    
        if (!$subjectId) {
            throw new \InvalidArgumentException("No se encontró una asignatura asociada al curso con ID $courseId.");
        }
    
        // Inserta en enrollments con student_id y subject_id
        $this->assignStudentToSubject($studentId, $subjectId);
    }

    // Asigna un estudiante a una asignatura específica
    public function assignStudentToSubject(int $studentId, int $subjectId): void
    {
        $query = "INSERT INTO enrollments (student_id, subject_id, enrollment_date) 
                  VALUES (:student_id, :subject_id, :enrollment_date)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'enrollment_date' => date('Y-m-d'),
        ]);
    }
    }