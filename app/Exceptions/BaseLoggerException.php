<?php

namespace App\Exceptions;

use App\Exceptions\BaseJsonException;
use Illuminate\Support\Facades\Log;

interface BaseLoggerExceptionInterface
{
    public function logException(string $logMessage): void;
}

class BaseLoggerException extends BaseJsonException implements BaseLoggerExceptionInterface
{
    public function logException(string $logMessage): void
    {
        Log::error($logMessage, [
            'message'     => $this->message,
            'errors'      => $this->errors,
            'status_code' => $this->statusCode,
        ]);
    }
}
