<?php
namespace Api\Models;

use Bitrix\Main\UserTable;
use Bitrix\Main\FileTable;

class Employee
{
    /**
     * Получить всех сотрудников
     */
    public static function getAll($limit = 50)
    {
        $result = UserTable::getList([
            'select' => ['ID', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'EMAIL', 'PERSONAL_PHOTO', 'WORK_POSITION'],
            'filter' => ['ACTIVE' => 'Y'],
            'limit' => $limit,
            'order' => ['ID' => 'ASC']
        ]);

        $employees = [];
        while ($user = $result->fetch()) {
            $employees[] = self::formatEmployee($user);
        }

        return $employees;
    }

    /**
     * Получить сотрудника по ID
     */
    public static function getById($id)
    {
        $result = UserTable::getList([
            'select' => ['ID', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'EMAIL', 'PERSONAL_PHOTO', 'WORK_POSITION'],
            'filter' => ['ID' => $id]
        ])->fetch();

        if (!$result) {
            return null;
        }

        return self::formatEmployee($result);
    }

    /**
     * Форматирование данных сотрудника
     */
    private static function formatEmployee($user)
    {
        $avatar = null;
        if ($user['PERSONAL_PHOTO']) {
            $file = \CFile::GetPath($user['PERSONAL_PHOTO']);
            $avatar = $file ? $_SERVER['HTTP_HOST'] . $file : null;
        }

        /**
         * Подсчёт задач
         */
        $tasksCount = Task::getCountByUserId($user['ID']);


        return [
            'id' => (int)$user['ID'],
            'name' => trim($user['NAME'] . ' ' . $user['LAST_NAME'] . ' ' . $user['SECOND_NAME']),
            'email' => $user['EMAIL'],
            'position' => $user['WORK_POSITION'] ?? 'Сотрудник',
            'avatar' => $avatar,
            'tasksCount' => $tasksCount,
            /*
            'reportsCount' => 0, // TODO: реальный подсчёт
            'completionRate' => 0, // TODO: реальный подсчёт
            'testRate' => 1000000000,
            */
        ];
    }
}