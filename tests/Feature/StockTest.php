<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->putJson('/api/watches/reset');
    }

    /** @test
     * @throws \Exception
     */
    public function user_can_get_amount_of_item_in_the_stock()
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

        $inStockResponse = $this->getJson('/api/stock/' . $firstItem['watch_id'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "item" => [
                    "watch_id",
                    "branch",
                    "series",
                    "model",
                    "case_size",
                    "bracelet_material",
                    "dial_color",
                    "status"
                ],
                "amount"
            ]);

        $inStock = $inStockResponse->json();
        $this->assertSame(1, $inStock['amount']);
    }
}
