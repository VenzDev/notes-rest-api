<?php

namespace Tests\Integration;

use App\Models\Note;
use App\Models\Version;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotesTest extends TestCase
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

    public function test_update_note()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => 'super fajny tytul',
            'content' => 'Mariusz Pudzianowski',
        ]);

        $response = $this->json('PUT', '/api/update-note', [
            'id' => 2,
            'title' => 'New Title',
            'content' => 'New content',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);
    }

    public function test_update_note_without_credentials()
    {
        $response = $this->json('PUT', '/api/update-note', []);

        $response->assertStatus(422);
        $response->assertJson(['message' =>
        [
            'id' => ['The id field is required.'],
            'title' => ['The title field is required.'],
            'content' => ['The content field is required.']
        ]]);
    }

    public function test_update_note_with_wrong_id()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => 'super fajny tytul',
            'content' => 'Mariusz Pudzianowski',
        ]);

        $response = $this->json('PUT', '/api/update-note', [
            'id' => 20,
            'title' => 'New Title',
            'content' => 'New content',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Something went wrong!']);
    }

    public function get_notes()
    {
        $response = $this->json('POST', '/api/create-note', [
            'title' => 'super fajny tytul',
            'content' => 'Mariusz Pudzianowski',
        ]);

        $response = $this->json('GET', '/api/notes');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success', 'data' => []]);
    }
}
