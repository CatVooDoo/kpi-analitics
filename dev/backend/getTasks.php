<?php
require_once __DIR__ . '/config.php';

// Load the tasks module
if (!\Bitrix\Main\Loader::includeModule('tasks')) {
    die('Error: Tasks module is not installed!');
}

$userId = 4;
$parameters = [
    'select' => ['ID', 'TITLE', 'STATUS', 'DESCRIPTION'],
    'filter' => [
        'RESPONSIBLE_ID' => $userId,
        'ZOMBIE' => 'N'
    ],
    'order' => ['CREATED_DATE' => 'DESC'],
    'limit' => 10
];

$dbResult = \Bitrix\Tasks\Internals\TaskTable::getList($parameters);
while ($task = $dbResult->fetch()) {
    echo "Задача ID: " . $task['ID'] . ", Название: " . $task['TITLE'] . ", Описание: " . $task['DESCRIPTION'] . ", Статус: " . $task['STATUS'] . "\n";
}