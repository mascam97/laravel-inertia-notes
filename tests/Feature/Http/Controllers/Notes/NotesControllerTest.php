<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $url = "/notes";

    public function test_guest()
    {
        $this->get("$this->url")->assertRedirect('login');        // index
        $this->get("$this->url/1")->assertRedirect('login');      // show
        $this->get("$this->url/1/edit")->assertRedirect('login'); // edit
        $this->put("$this->url/1")->assertRedirect('login');      // update
        $this->delete("$this->url/1")->assertRedirect('login');   // destroy
        $this->get("$this->url/create")->assertRedirect('login'); // create
        $this->post("$this->url", [])->assertRedirect('login');   // store
    }

    public function test_index_empty()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($this->url);
        $response->assertStatus(200);
        $response->assertSee(htmlspecialchars_decode('notes&quot;:[]'));
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create();

        $note = Note::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get($this->url);
        $response->assertStatus(200);
        $response->assertSee($note->title);
        $response->assertSee($user->name);
        $response->assertDontSee(htmlspecialchars_decode('notes&quot;:[]'));
    }

    public function test_validate_store()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("$this->url", [
            'title' => '',
            'content' => ''
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertStatus(302);
    }

    public function test_store()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($this->url, [
            'title' => 'title',
            'content' => 'content'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', ['title' => 'title']);
    }

    public function test_show_and_edit()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => $this->faker->text,
            'content' => $this->faker->text
        ];
        $note = Note::factory()->create($data);

        $response_show = $this->actingAs($user)->get("$this->url/{$note->id}");

        $response_show->assertStatus(200);
        $response_show->assertSee($data['title']);
        $response_show->assertSee($data['content']);

        $response_edit = $this->actingAs($user)->get("$this->url/{$note->id}/edit");

        $response_edit->assertStatus(200);
        $response_edit->assertSee($data['title']);
        $response_edit->assertSee($data['content']);
    }

    public function test_validate_update()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => $this->faker->text,
            'content' => $this->faker->text
        ]);

        $response = $this->actingAs($user)->put("$this->url/{$note->id}", [
            'title' => '',
            'content' => ''
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertStatus(302);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'old title',
            'content' => 'old content'
        ]);

        $response = $this->actingAs($user)->put("$this->url/{$note->id}", [
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
        $this->assertDatabaseMissing('notes', [
            'user_id' => $note->user_id,
            'title' => 'post to delete'
            ]);
    }
}
