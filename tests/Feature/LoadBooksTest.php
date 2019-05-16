<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoadBooks extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        for ($i=0; $i<11;$i++)
        {
            $response = $this->json('POST', '/api/book', ["title"=>"Book " . $i,
            "author"=>"Person " . $i,
            "blurb"=>"Info " . $i ,
            "ISBN"=>"1236454" . $i,
            "release_year"=>"2019",
            "number_pages"=>"345" . $i
            ]);
            $response->assertStatus(200);
        }


    }
}
