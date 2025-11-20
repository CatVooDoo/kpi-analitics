<?php
namespace Api\Controllers;

use Api\Models\Employee;
use Api\Helpers\Response;

class EmployeeController
{
    /**
     * GET /backend/index.php?resource=employees
     */
    public static function index()
    {
        try {
            $params = Response::getParams();
            $limit = isset($params['limit']) ? (int)$params['limit'] : 50;

            $employees = Employee::getAll($limit);

            Response::success($employees, 'Список сотрудников получен');
        } catch (\Exception $e) {
            Response::error('Ошибка получения сотрудников: ' . $e->getMessage(), 500);
        }
    }

    /**
     * GET /backend/index.php?resource=employees&id=123
     */
    public static function show()
    {
        try {
            $params = Response::getParams();
            $id = isset($params['id']) ? (int)$params['id'] : 0;

            if (!$id) {
                Response::error('ID сотрудника не указан', 400);
            }

            $employee = Employee::getById($id);

            if (!$employee) {
                Response::error('Сотрудник не найден', 404);
            }

            Response::success($employee, 'Данные сотрудника получены');
        } catch (\Exception $e) {
            Response::error('Ошибка получения сотрудника: ' . $e->getMessage(), 500);
        }
    }
}
