<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->json('POST', '/graphql', ['query' => "{ news{id, title }}"])
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
