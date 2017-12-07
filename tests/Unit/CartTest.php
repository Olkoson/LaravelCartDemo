<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class CartTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'ProductsTableSeeder']);
    }

    public function testAddToCart()
    {
        $productId = 1;

        $this->assertDatabaseMissing('carts', [
            'product_id' => $productId
        ]);

        $response  = $this->post(
            '/cart/add',
            ['product_id' => $productId]
        );

        $this->assertDatabaseHas('carts', [
            'product_id' => $productId
        ]);

        $response->assertRedirect('products');
    }

    public function testAddToCartWithQuantity()
    {
        $productId = 1;
        $quantity = 1;
        $this->assertDatabaseHas('carts', [
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
        $response  = $this->post(
            '/cart/add',
            ['product_id' => $productId]
        );

        $this->assertDatabaseHas('carts', [
            'product_id' => $productId,
            'quantity' => $quantity + 1,
        ]);

        $response->assertRedirect('products');
    }

    public function testRemoveItemFromCart()
    {
        $id = 1;

        $this->assertDatabaseHas('carts', [
            'id' => $id
        ]);

        $response  = $this->post(
            '/cart/remove',
            ['id' => $id]
        );

        $this->assertDatabaseMissing('carts', [
            'id' => $id
        ]);


        $response->assertRedirect('cart');
    }

    public function testRemoveAllItemsFromCart()
    {
        $userId = 1;
        $productId1 = 1;
        $productId2 = 2;

        $response  = $this->post(
            '/cart/add', [
                'product_id' => $productId1,
                'user_id' => $userId
            ]
        );
        $response  = $this->post(
            '/cart/add', [
                'product_id' => $productId2,
                'user_id' => $userId
            ]
        );

        $this->assertDatabaseHas('carts', [
            'user_id' => $userId
        ]);

        $response  = $this->post(
            '/cart/clear',
            ['user_id' => $userId]
        );

        $this->assertDatabaseMissing('carts', [
            'user_id' => $userId
        ]);


        $response->assertRedirect('cart');
    }
}
