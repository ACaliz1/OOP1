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

$db = DatabaseConnection::getConnection();
$services = new Services();
$services->addServices('db', fn() => $db);
$db = $services->getService('db');

// Configuración de rutas
$router = new Router();
$router->addRoute('GET', '/', [new HomeController(), 'index'])
    ->addRoute('GET', '/home', [new HomeController(), 'index'])
    ->addRoute('GET', '/teacher', [new TeacherController(), 'showData'])
    ->addRoute('POST', '/teacherPostForm', [new TeacherController(), 'receivePostAndSendToTeacherService'])
    ->addRoute('POST', '/assign-department', [new TeacherController(), 'receivePostAndSendToDepartmentService'])
    ->addRoute('POST', '/create-department', [new DepartmentController(), 'receiveAndCreateDepartment'])
    ->addRoute('GET', '/student', [new StudentController(), 'showData'])
    ->addRoute('POST', '/create-student', [new StudentController(), 'receivePostAndSendToStudentService'])
    ->addRoute('POST', '/create-course', [new CourseController(), 'receivePostAndSendToCourseService'])
    ->addRoute('POST', '/assign-course', [new CourseController(), 'receivePostAndAssignWithCourseService'])
    ->addRoute('GET', '/get-subjects', [new SubjectController(), 'getSubjectsByCourse'])
    ->addRoute('GET', '/course', action: [new SubjectController(), 'showData'])
    ->addRoute('POST', '/create-subject', action: [new SubjectController(), 'createSubject']);





