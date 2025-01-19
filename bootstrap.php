<?php
define('VIEWS', __DIR__ . '/src/views');
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Controllers\HomeController;
use App\Controllers\TeacherController;
use App\Controllers\DepartmentController;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Routing\Router;
use App\School\Services\Services;
use App\Controllers\StudentController;
use App\Controllers\CourseController;
use App\Controllers\SubjectController;
use App\Controllers\EnrollmentController;

$db = DatabaseConnection::getConnection();
$services = new Services();
$services->addServices('db', fn() => $db);
$db = $services->getService('db');

// Configuración de rutas
$router = new Router();

        // Rutas home 
$router->addRoute('GET', '/', [new HomeController(), 'index'])
       ->addRoute('GET', '/home', [new HomeController(), 'index'])
    
    // Rutas GET y POST Teacher
    ->addRoute('GET', '/teacher', [new TeacherController(), 'showData'])
    ->addRoute('POST', '/teacherPostForm', [new TeacherController(), 'receivePostAndSendToTeacherService'])

    //Rutas POST crear y asignar departamento
    ->addRoute('POST', '/create-department', [new DepartmentController(), 'receiveAndCreateDepartment'])
    ->addRoute('POST', '/assign-department', [new TeacherController(), 'receivePostAndSendToDepartmentService'])

    //Rutas GET y POST Student
    ->addRoute('GET', '/student', [new StudentController(), 'showData'])
    ->addRoute('POST', '/create-student', [new StudentController(), 'receivePostAndSendToStudentService'])

    //Rutas GET y POST Cursos
    ->addRoute('GET', '/courses', action: [new EnrollmentController(), 'showData'])
    ->addRoute('POST', '/create-course', [new CourseController(), 'receivePostAndSendToCourseService'])
    ->addRoute('POST', '/assign-course', [new EnrollmentController(), 'receivePostAndAssignWithCourseService'])

    //Rutas GET y POST de Subjects
    ->addRoute('GET', '/get-subjects', [new SubjectController(), 'getSubjectsByCourse'])
    ->addRoute('POST', '/create-subject', action: [new SubjectController(), 'createSubject']);





