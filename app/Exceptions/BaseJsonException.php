<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

interface JsonExceptionInterface
{
    public function getResponseData(): array;
    public function getStatusCode(): int;
}

class BaseJsonException extends HttpResponseException  implements JsonExceptionInterface
{
    protected $errors;
    protected $message;
    protected $statusCode;

    public function __construct(array $errors, string $message = 'The given data was invalid', int $statusCode = 400)
    {
        $response = response()->json([
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);

        parent::__construct($response);
    }

    public function getResponseData(): array
    {
        return [
            'message' => $this->message,
            'errors'  => $this->errors,
        ];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
