<?php

namespace App\Services;

class BaseService
{
    protected function transformData($success, $message, $data = null, $statusCode = 200): array
    {
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ];
    }
}
