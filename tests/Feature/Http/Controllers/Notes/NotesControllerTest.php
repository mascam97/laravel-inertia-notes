<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Domain\Users\Models\User;
use App\Domain\Notes\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private string $url = '/notes';

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
}
