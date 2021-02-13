<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_note()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => 'super fajny tytul',
            'content' => 'Mariusz Pudzianowski',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);
    }

    public function test_create_note_without_title()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => '',
            'content' => 'Mariusz Pudzianowski',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => ['title' => ['The title field is required.']]]);
    }

    public function test_create_note_without_content()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => 'Title',
            'content' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => ['content' => ['The content field is required.']]]);
    }
}
