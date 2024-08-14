<?php

namespace App\Exceptions\OrderExceptions;

use App\Exceptions\BaseJsonException;

class OrderNameFormatException extends BaseJsonException
{
    public function __construct(String $message)
    {
        $errors = [
            'name' => $message,
        ];

        parent::__construct($errors);
    }
}
