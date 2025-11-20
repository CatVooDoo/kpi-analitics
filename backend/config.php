<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

\Bitrix\Main\Loader::includeModule('main');
\Bitrix\Main\Loader::includeModule('tasks');

// Проверка авторизации (опционально)
global $USER;
if (!$USER->IsAuthorized()) {
     http_response_code(401);
     echo json_encode(['error' => 'Unauthorized']);
     exit();
}