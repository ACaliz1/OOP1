<?php 

    namespace App\School\Services;

    use App\Infrastructure\Database\DatabaseConnection;

    use App\Infrastructure\Persistence\SubjectRepository;
    use App\Infrastructure\Persistence\EnrollmentRepository;

    class EnrollmentService{
        private SubjectRepository $subjectRepository;
        private EnrollmentRepository $enrollmentRepository;

        function __construct(SubjectRepository $subjectRepository, EnrollmentRepository $enrollmentRepository)
        {
            $db = DatabaseConnection::getConnection();

            $this->subjectRepository = $subjectRepository;
            $this->enrollmentRepository = $enrollmentRepository;

        }

        public function assignStudentToCourse(int $courseId, int $studentId): void
        {
            $subjects = $this->subjectRepository->findByCourseId($courseId);
            if (empty($subjects)) {
                throw new \InvalidArgumentException("El curso seleccionado no tiene asignaturas.");
            }
    
            $subjectId = $_POST['subject_id'];
            $this->enrollmentRepository->assignStudentToSubject($studentId, $subjectId);
        }
    }