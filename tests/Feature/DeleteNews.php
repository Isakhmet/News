<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNews extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->json('POST', '/graphql', ['query' => "mutation{
            deleteNews(
            id: 12
            ){
            alias
            }
        }"
        ])
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
