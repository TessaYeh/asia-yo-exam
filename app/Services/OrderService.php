<?php

namespace App\Services;

use App\Constants\OrderConstant;
use App\Exceptions\OrderExceptions\OrderPriceOverException;
use App\Exceptions\OrderExceptions\OrderNameFormatException;

class OrderService
{
    /**
     * 檢查並轉換訂單資料
     * @param array $input
     * @return array
     */
    public function validateAndTransformOrder(array $input): array
    {
        $transformData = $this->transformCurrencyAndPrice($input['currency'], (int) $input['price']);

        $this->checkHotelName($input['name']);
        $this->checkPrice((int) $transformData['price']);

        return array_merge($input, $transformData);
    }

    /**
     * 檢查旅宿名稱
     * @param string $name
     * @throws \App\Exceptions\OrderExceptions\OrderNameFormatException
     * @return void
     */
    private function checkHotelName(String $name): void
    {
        foreach (OrderConstant::NAME_PATTERNS as $pattern) {
            if (!preg_match($pattern['regex'], $name)) {
                throw new OrderNameFormatException($pattern['message']);
            }
        }
    }

    /**
     * 檢查訂單金額
     * @param int $price
     * @throws \App\Exceptions\OrderExceptions\OrderPriceOverException
     * @return void
     */
    private function checkPrice(int $price): void
    {
        if ($price > OrderConstant::PRICE_UPPER_LIMIT) {
            throw new OrderPriceOverException($price);
        }
    }

    /**
     * 轉換幣別及對應金額
     * @param string $inputCurrency
     * @param int $inputPrice
     * @return array
     */
    private function transformCurrencyAndPrice(String $inputCurrency, int $inputPrice): array
    {
        $currency = $inputCurrency;
        $price = $inputPrice;

        if ($currency != OrderConstant::CURRENCY_TWD) {
            $price *= OrderConstant::CURRENCY_EXCHANGE_RATES[$inputCurrency];
            $currency = OrderConstant::CURRENCY_TWD;
        }

        $price = (string) $price;

        return compact('currency', 'price');
    }
}
