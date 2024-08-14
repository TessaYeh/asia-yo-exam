<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderService;
use App\Constants\OrderConstant;
use App\Exceptions\OrderExceptions\OrderPriceOverException;
use App\Exceptions\OrderExceptions\OrderNameFormatException;

class OrderFormatTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    public function testValidateAndTransformOrderWithValidData()
    {
        $input = [
            'id'      => 'A0000001',
            'name'    => 'MelodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => '30',
            'currency' => 'USD',
        ];

        $expected = [
            'id'      => 'A0000001',
            'name'    => 'MelodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => (string)(30 * OrderConstant::CURRENCY_EXCHANGE_RATES['USD']),
            'currency' => 'TWD',
        ];

        $result = $this->orderService->validateAndTransformOrder($input);

        $this->assertEquals($expected, $result);
    }

    public function testValidateAndTransformOrderWithInvalidPrice()
    {
        $this->expectException(OrderPriceOverException::class);

        $input = [
            'id'      => 'A0000001',
            'name'    => 'MelodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => (string)(OrderConstant::PRICE_UPPER_LIMIT + 1),
            'currency' => 'TWD',
        ];

        $this->orderService->validateAndTransformOrder($input);
    }

    public function testValidateAndTransformOrderWithInvalidName()
    {
        $this->expectException(OrderNameFormatException::class);

        $input = [
            'id'      => 'A0000001',
            'name'    => 'melodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => '1000',
            'currency' => 'USD',
        ];

        $this->orderService->validateAndTransformOrder($input);
    }
}
