<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers/Response.php';
require_once __DIR__ . '/models/Employee.php';
require_once __DIR__ . '/controllers/EmployeeController.php';

use Api\Helpers\Response;
use Api\Controllers\EmployeeController;

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
            Response::success([], 'Задачи пока не реализованы');
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
