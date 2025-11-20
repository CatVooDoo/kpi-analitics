<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers/Response.php';
require_once __DIR__ . '/models/Employee.php';
require_once __DIR__ . '/models/Task.php';
require_once __DIR__ . '/controllers/EmployeeController.php';
require_once __DIR__ . '/controllers/TaskController.php';


use Api\Helpers\Response;
use Api\Controllers\EmployeeController;
use Api\Controllers\TaskController;


$resource = $_GET['resource'] ?? null;
$id = $_GET['id'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

// Роутинг
try {
    switch ($resource) {

        // Сотрудники
        case 'employees':
            if ($id) {
                EmployeeController::show();
            } else {
                EmployeeController::index();
            }
            break;


        case 'tasks':
            if ($id) {
                TaskController::show();
            } else {
                TaskController::index();
            }
            break;


        case 'reports':
            Response::success([], 'Отчёты пока не реализованы');
            break;

        case 'stats':
            Response::success([
                'totalEmployees' => 4,
                'totalTasks' => 5,
                'totalReports' => 5,
                'avgCompletionRate' => 85.5
            ], 'Статистика получена');
            break;

        default:
            Response::error('Ресурс не найден. Используйте: employees, tasks, reports, stats', 404);
    }

} catch (\Exception $e) {
    Response::error('Внутренняя ошибка сервера: ' . $e->getMessage(), 500);
}