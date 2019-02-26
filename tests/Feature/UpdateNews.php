<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateNews extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $count = rand(0, 1000);

        $this->json('POST', '/graphql', ['query' => "mutation{
        updateNews(
    		id: \"12\"
    		title: \"Title\", 
            alias: \"Alias num $count\",
            anons: \"Anons\"
            description: \"description\",
            status: false,
            active_at: \"2019-02-24 00:00:00\"
            settings: \"Settings\"
            created_at: \"2019-02-24 00:00:00\"
        
        ){
            id,
            alias,
            title
         }
        }"
        ])
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
