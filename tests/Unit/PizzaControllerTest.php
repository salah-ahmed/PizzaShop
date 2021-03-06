<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use JWTAuth;

class PizzaControllerTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_ROUTE="api/pizza/";

    public function testIndexHttpStatusCode()
    {
        $result = $this->call('GET', self::BASE_ROUTE);
        $result->assertOk();
    }

    public function testIndexResponse()
    {
        $category = factory(\App\Category::class)->create();
        factory(\App\Pizza::class)->create();

        $result = $this->json('GET', self::BASE_ROUTE);
        $result
            ->assertOk()
            ->assertJsonStructure([
                [
                    'id',
                    'dough',
                    'toppings_count',
                    'name',
                    'size',
                    'price'
                ]
            ]);
    }

    public function testShowResponse()
    {
        $pizza = factory(\App\Pizza::class)->create();

        $result = $this->json('get', self::BASE_ROUTE.$pizza->id);
        $result
        ->assertOk()
        ->assertJsonStructure([
                'id',
                'name',
                'dough',
                'size',
                'price',
                'toppings_count',
                'created_at',
                'updated_at',
        ]);
    }

    public function testDelete()
    {
        $adminUser = factory(\App\User::class)->create(['is_admin'=>true]);
        $token=JWTAuth::fromUser($adminUser);

        $pizza = factory(\App\Pizza::class)->create();

        $result = $this->json('delete', self::BASE_ROUTE.$pizza->id, [
            'token' => $token
        ]);
        $result->assertStatus(201);
    }

    public function testStore()
    {
        $adminUser = factory(\App\User::class)->create(['is_admin'=>true]);
        $token=JWTAuth::fromUser($adminUser);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Connection' => 'close'
        ])->json('POST', self::BASE_ROUTE,
            [
                "name" => "new_pizza",
                "dough" => "regular",
                "toppings_count" => 3,
                "size" => "small",
                "price" => 6,
                "token" => $token
            ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                "created" => true,
            ]);
    }

    public function testUpdate()
    {
        $adminUser = factory(\App\User::class)->create(['is_admin'=>true]);
        $token=JWTAuth::fromUser($adminUser);

        $pizza = factory(\App\Pizza::class)->create();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Connection' => 'close'
        ])->json('PATCH', self::BASE_ROUTE.$pizza->id,
            [
                'name' => 'updated_pizza',
                'price'=>7,
                'token' => $token
            ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                "updated" => true,
            ]);
    }
}
