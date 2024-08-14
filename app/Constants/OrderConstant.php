<?php

namespace App\Constants;

class OrderConstant
{
    /**
     * 幣別：新台幣
     * @var string
     */
    const CURRENCY_TWD = 'TWD';
    /**
     * 幣別：美金
     * @var string
     */
    const CURRENCY_USD = 'USD';

    /**
     * 外幣對台幣匯率清單
     * @var array
     */
    const CURRENCY_EXCHANGE_RATES = [
        self::CURRENCY_USD => 31,
    ];

    /**
     * 訂單最高金額(台幣)
     * @var int
     */
    const PRICE_UPPER_LIMIT = 2000;

    /**
     * 訂單姓名正規表示清單
     * @var array
     */
    const NAME_PATTERNS = [
        [
            'regex' => '/^[a-zA-Z]+$/',
            'message' => 'Name contains non-English characters',
        ],
        [
            'regex' => '/^[A-Z]/',
            'message' => 'Name is not capitalized',
        ]
    ];
}
