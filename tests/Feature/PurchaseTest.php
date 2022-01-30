<?php

namespace Tests\Feature;

use App\Events\ItemWasSold;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->putJson('/api/watches/reset');
    }

    /** @test
     * @throws \Exception
     */
    public function user_can_purchase_an_item()
    {
        Event::fake();
        $watches = $this->get('/api/watches')
            ->assertStatus(200)
            ->json();

        $firstItem = $watches[0];

        $inStockResponse = $this->getJson('/api/stock/' . $firstItem['watch_id'])
            ->assertStatus(200);

        $inStock = $inStockResponse->json();
        $this->assertGreaterThan(0, $inStock["amount"]);

        $cartItem = $this->postJson('/api/cart', ['id' => $firstItem['watch_id']] )
            ->assertStatus(200);
        $this->assertEquals($firstItem, $cartItem->json());

        $cartItem = $this->getJson('/api/cart')
            ->assertStatus(200);
        $this->assertEquals($firstItem, $cartItem->json());

        $purchase = $this->postJson('/api/purchase/')
            ->assertStatus(200);

        Event::assertDispatched(ItemWasSold::class);

        $inStockAfter = $this->getJson('/api/stock/' . $firstItem['watch_id'])
            ->assertStatus(200);

        $this->assertSame(0, $inStockAfter->json('amount'));

        $cartItemAfter = $this->getJson('/api/cart')
            ->assertStatus(200);

        $this->assertEmpty($cartItemAfter->json());

        $this->assertTrue( $purchase->json('success'));
        $this->assertEquals( "Successfully Sold Message", $purchase->json('message'));
    }


    /** @test
     * @throws \Exception
     */
    public function user_can_not_purchase_an_item_which_was_already_sold()
    {
        $userOne = 1;
        $userTwo = 2;

        Event::fake();
        $watches = $this->get('/api/watches')
            ->assertStatus(200)
            ->json();

        $firstItem = $watches[0];

        $inStockResponse = $this->getJson('/api/stock/' . $firstItem['watch_id'])
            ->assertStatus(200);

        $inStock = $inStockResponse->json();
        $this->assertGreaterThan(0, $inStock["amount"]);

        $userOneCartItem = $this->postJson('/api/cart',
            [
                'id' => $firstItem['watch_id'],
                'user_id' => $userOne
            ])
            ->assertStatus(200);
        $this->assertEquals($firstItem, $userOneCartItem->json());


        $userTwoCartItem = $this->postJson('/api/cart',
            [
                'id' => $firstItem['watch_id'],
                'user_id' => $userTwo
            ])
            ->assertStatus(200);
        $this->assertEquals($firstItem, $userTwoCartItem->json());


        $cartItem = $this->getJson('/api/cart')
            ->assertStatus(200);
        $this->assertEquals($firstItem, $cartItem->json());

        $purchase = $this->postJson('/api/purchase/', ['user_id' => $userTwo])
            ->assertStatus(200);

        Event::assertDispatched(ItemWasSold::class);

        $inStockAfter = $this->getJson('/api/stock/' . $firstItem['watch_id'])
            ->assertStatus(200);

        $this->assertSame(0, $inStockAfter->json('amount'));

        $userTwoCartItemAfter = $this->getJson('/api/cart/' . $userTwo)
            ->assertStatus(200);

        $this->assertEmpty($userTwoCartItemAfter->json());

        $this->assertTrue( $purchase->json('success'));
        $this->assertEquals( "Successfully Sold Message", $purchase->json('message'));

        $userOnePurchase = $this->postJson('/api/purchase/', ['user_id' => $userOne])
            ->assertStatus(401);

        $this->assertFalse($userOnePurchase->json('success'));
        $this->assertEquals('Not enough items in the Stock' ,$userOnePurchase->json('error'));
    }
}
