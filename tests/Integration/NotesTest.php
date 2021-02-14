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
        $this->createNote();

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
        $this->createNote();

        $response = $this->json('PUT', '/api/update-note', [
            'id' => 20,
            'title' => 'New Title',
            'content' => 'New content',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Something went wrong!']);
    }

    public function test_get_notes()
    {
        $this->createNote();

        $response = $this->json('GET', '/api/notes');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success', 'data' => []]);
    }

    public function test_get_note()
    {
        $this->createNote();

        $response = $this->json('GET', '/api/note/5');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success', 'data' => []]);
    }

    public function test_get_note_with_wrong_id()
    {
        $this->createNote();

        $response = $this->json('GET', '/api/note/50');

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Something went wrong!']);
    }

    public function test_delete_note()
    {
        $this->createNote();

        $response = $this->json('DELETE', '/api/delete-note/7');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);
    }

    public function test_get_note_version()
    {
        $this->createNote();

        $response = $this->json('GET', '/api/get-note-history/8');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);
    }

    public function test_get_note_version_with_wrong_id()
    {
        $this->createNote();

        $response = $this->json('GET', '/api/get-note-history/80');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);
    }

    private function createNote()
    {
        $this->json('POST', '/api/create-note', [
            'title' => 'super fajny tytul',
            'content' => 'Mariusz Pudzianowski',
        ]);
    }
}
