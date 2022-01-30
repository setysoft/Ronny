<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->putJson('/api/watches/reset');
    }

    /** @test */
    public function user_can_add_item_to_the_cart()
    {
        $watches = $this->get('/api/watches')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'watch_id',
                    'branch',
                    'series',
                    'model',
                    'case_size',
                    'bracelet_material',
                    'dial_color',
                    'status',
                ]
            ])->json();

        $firstItem = $watches[0];

        $cartItem = $this->postJson('/api/cart', ['id' => $firstItem['watch_id']] );
        $this->assertEquals($firstItem, $cartItem->json());

        $cartItem = $this->getJson('/api/cart');
        $this->assertEquals($firstItem, $cartItem->json());
    }

    /** @test */
    public function user_can_clear_the_cart()
    {
        $watches = $this->get('/api/watches')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'watch_id',
                    'branch',
                    'series',
                    'model',
                    'case_size',
                    'bracelet_material',
                    'dial_color',
                    'status',
                ]
            ])->json();

        $firstItem = $watches[0];

        $cartItem = $this->postJson('/api/cart', ['id' => $firstItem['watch_id']] )
            ->assertStatus(200);
        $this->assertEquals($firstItem, $cartItem->json());


        $deleted = $this->deleteJson('/api/cart')
            ->assertStatus(200);

        $this->assertTrue($deleted->json('success'));

        $cart = $this->getJson('/api/cart')
            ->assertStatus(200);

        $this->assertEmpty($cart->json());
    }
}
