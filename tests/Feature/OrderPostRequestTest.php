<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderPostRequestTest extends TestCase
{
    public function testRequiresAllFields(): void
    {
        $response = $this->postJson('api/orders', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'id',
            'name',
            'address.city',
            'address.district',
            'address.street',
            'price',
            'currency'
        ]);
    }

    public function testValidatesCurrencyField()
    {
        $response = $this->postJson('api/orders', [
            'id'      => 'A0000001',
            'name'    => 'MelodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => '1000',
            'currency' => 'INVALID',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['currency']);
    }

    public function testPassValidation()
    {
        $response = $this->postJson('api/orders', [
            'id'      => 'A0000001',
            'name'    => 'MelodyHolidayInn',
            'address' => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
            'price'    => '1000',
            'currency' => 'TWD',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'isValid',
                'order' => [
                    'id',
                    'name',
                    'address' => [
                        'city',
                        'district',
                        'street',
                    ],
                    'price',
                    'currency',
                ],
            ],
        ]);
    }
}
