<?php

namespace App\Exceptions\OrderExceptions;

use App\Exceptions\BaseLoggerException;

use App\Constants\OrderConstant;

class OrderPriceOverException extends BaseLoggerException
{
    public function __construct(string $price)
    {
        $errors = [
            'price' => [
                'Price is over ' . OrderConstant::PRICE_UPPER_LIMIT . ' TWD',
            ],
        ];

        parent::__construct($errors);

        $this->logException("The input price is: $price");
    }
}
