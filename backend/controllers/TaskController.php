<?php
namespace Api\Controllers;

use Api\Models\Task;
use Api\Helpers\Response;

class TaskController
{
    /**
     * GET /backend/index.php?resource=tasks
     */
    public static function index()
    {
        try {
            $params = Response::getParams();
            $limit = isset($params['limit']) ? (int)$params['limit'] : 50;

            $tasks = Task::getAll($limit);

            Response::success($tasks, 'Список задач получен');
        } catch (\Exception $e) {
            Response::error('Ошибка получения задач: ' . $e->getMessage(), 500);
        }
    }

    /**
     * GET /backend/index.php?resource=tasks&id=123
     */
    public static function show()
    {
        try {
            $params = Response::getParams();
            $id = isset($params['id']) ? (int)$params['id'] : 0;

            if (!$id) {
                Response::error('ID задачи не указан', 400);
            }

            $task = Task::getById($id);

            if (!$task) {
                Response::error('Задача не найдена', 404);
            }

            Response::success($task, 'Данные задачи получены');
        } catch (\Exception $e) {
            Response::error('Ошибка получения задачи: ' . $e->getMessage(), 500);
        }
    }
}