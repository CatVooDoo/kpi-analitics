<?php
namespace Api\Helpers;

class Response
{
    /**
     * успешно
     */
    public static function success($data, $message = 'OK', $code = 200)
    {
        http_response_code($code);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }

    /**
     * ошибка
     */
    public static function error($message, $code = 400, $errors = [])
    {
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }

    /**
     * json из тела зпроса
     */
    public static function getRequestBody()
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }

    /**
     * параметры из урл
     */
    public static function getParams()
    {
        return $_GET;
    }
}
