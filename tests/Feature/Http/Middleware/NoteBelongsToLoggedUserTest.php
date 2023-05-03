<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteBelongsToLoggedUserTest extends TestCase
{
    use RefreshDatabase;

    private $url = "/notes";

    public function test_updated_not_allowed_by_not_owner()
    {
        $user_owner = User::factory()->create();

        $note = Note::factory()->user($user_owner)->create([
            'title' => 'old title',
            'content' => 'old content'
        ]);

        $userMalicious = User::factory()->create();

        $response = $this->actingAs($userMalicious)->put("$this->url/$note->id", [
            'title' => 'new title not allowed',
            'content' => 'new content not allowed'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', [
            'title' => 'old title',
            'content' => 'old content'
        ]);
        $this->assertDatabaseMissing('notes', [
            'title' => 'new title not allowed',
            'content' => 'new content not allowed'
        ]);
    }

    public function test_edit_and_show_by_owner_and_no_owner()
    {
        $user_owner = User::factory()->create();
        $note = Note::factory()->user($user_owner)->create([
            'title' => 'old title',
            'content' => 'old content'
        ]);

        $this->actingAs($user_owner)->get("$this->url/$note->id")->assertStatus(200);
        $this->actingAs($user_owner)->get("$this->url/$note->id/edit")->assertStatus(200);

        $userMalicious = User::factory()->create();

        $response_show = $this->actingAs($userMalicious)->get("$this->url/$note->id");
        $response_show->assertStatus(302);
        $response_show->assertRedirect('notes');

        $response_edit = $this->actingAs($userMalicious)->get("$this->url/$note->id/edit");
        $response_edit->assertStatus(302);
        $response_edit->assertRedirect('notes');

        $this->assertDatabaseHas('notes', [
            'title' => 'old title',
            'content' => 'old content'
        ]);
    }

    public function test_destroy_not_allowed_by_not_owner()
    {
        $user_owner = User::factory()->create();

        $note = Note::factory()->user($user_owner)->create([
            'title' => 'old title',
            'content' => 'old content'
        ]);

        $userMalicious = User::factory()->create();

        $response = $this->actingAs($userMalicious)->delete("$this->url/$note->id");
        $response->assertStatus(302);
        $response->assertRedirect('notes');

        $this->assertDatabaseHas('notes', [
            'title' => 'old title',
            'content' => 'old content'
        ]);
    }
}
