<?php 

    namespace App\School\Services;

    use App\Infrastructure\Persistence\SubjectRepository;
    use App\Infrastructure\Persistence\EnrollmentRepository;

    class EnrollmentService{
        private SubjectRepository $subjectRepository;
        private EnrollmentRepository $enrollmentRepository;

        function __construct(SubjectRepository $subjectRepository, EnrollmentRepository $enrollmentRepository)
        {

            $this->subjectRepository = $subjectRepository;
            $this->enrollmentRepository = $enrollmentRepository;

        }

        public function assignStudentToCourse(int $courseId, int $studentId, ?int $subjectId): void
    {
        $subjects = $this->subjectRepository->findByCourseId($courseId);

        if (empty($subjects)) {
            throw new \InvalidArgumentException("El curso seleccionado no tiene asignaturas.");
        }

        if ($subjectId && !$this->subjectRepository->existsByIdAndCourse($subjectId, $courseId)) {
            throw new \InvalidArgumentException("La asignatura seleccionada no pertenece al curso.");
        }

        $this->enrollmentRepository->assignStudentToSubject($studentId, $subjectId ?? $subjects[0]['id']);
    }
    }