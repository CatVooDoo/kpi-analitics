<?php
namespace Api\Models;

use Bitrix\Tasks\Internals\TaskTable;

class Task
{
    /**
     * Получить количество задач для пользователя
     */
    public static function getCountByUserId($userId)
    {
        try {
            if (!\Bitrix\Main\Loader::includeModule('tasks')) {
                return 0;
            }

            $result = TaskTable::getList([
                'select' => ['ID'],
                'filter' => [
                    'RESPONSIBLE_ID' => $userId,
                    'ZOMBIE' => 'N'
                ],
                'count_total' => true
            ]);

            return $result->getCount();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Получить все задачи
     */
    public static function getAll($limit = 50)
    {
        try {
            if (!\Bitrix\Main\Loader::includeModule('tasks')) {
                return [];
            }

            $result = TaskTable::getList([
                'select' => ['ID', 'TITLE', 'STATUS', 'DESCRIPTION', 'RESPONSIBLE_ID', 'DEADLINE'],
                'filter' => ['ZOMBIE' => 'N'],
                'limit' => $limit,
                'order' => ['CREATED_DATE' => 'DESC']
            ]);

            $tasks = [];
            while ($task = $result->fetch()) {
                $tasks[] = self::formatTask($task);
            }

            return $tasks;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Получить задачу по ID
     */
    public static function getById($id)
    {
        try {
            if (!\Bitrix\Main\Loader::includeModule('tasks')) {
                return null;
            }

            $result = TaskTable::getList([
                'select' => ['ID', 'TITLE', 'STATUS', 'DESCRIPTION', 'RESPONSIBLE_ID', 'DEADLINE'],
                'filter' => ['ID' => $id]
            ])->fetch();

            if (!$result) {
                return null;
            }

            return self::formatTask($result);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Форматирование данных задачи
     */
    private static function formatTask($task)
    {
        return [
            'id' => (int)$task['ID'],
            'title' => $task['TITLE'],
            'deadline' => $task['DEADLINE'],
            'status' => $task['STATUS'],
            'description' => $task['DESCRIPTION'],
            'responsibleId' => (int)$task['RESPONSIBLE_ID']
        ];
    }
}