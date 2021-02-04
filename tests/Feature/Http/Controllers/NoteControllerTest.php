<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;
    
    private $url = "/notes";

    public function test_guest_not_allowed()
    {
        $response = $this->get($this->url);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($this->url);
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($this->url,[
            'title' => 'title',
            'content' => 'content'
        ]);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', ['title' => 'title']);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'old title',
            'content' => 'old content'
        ]);

        $response = $this->actingAs($user)->put("$this->url/{$note->id}",[
            'title' => 'new title',
            'content' => 'new content'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', [
            'title' => 'new title',
            'content' => 'new content'
            ]);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'post to delete'
        ]);

        $response = $this->actingAs($user)->delete("$this->url/{$note->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('notes', ['title' => 'post to delete']);
    }

    public function test_request_data_validated()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->post("$this->url", [
            'title' => '',
            'content' => ''
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertStatus(302);
    }
}
