<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchesTest extends TestCase
{
    /** @test */
    public function it_returns_watches_list()
    {
        $this->get('/api/watches')
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
        ]);
    }
}
