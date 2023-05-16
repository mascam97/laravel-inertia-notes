<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/notes';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_routes_requires_authentication()
    {
        $this->getJson("$this->url")->assertUnauthorized();        // index
        $this->getJson("$this->url/1")->assertUnauthorized();      // show
        $this->postJson("$this->url", [])->assertUnauthorized();   // store
        $this->putJson("$this->url/1")->assertUnauthorized();      // update
        $this->deleteJson("$this->url/1")->assertUnauthorized();   // destroy
    }

    public function test_routes_return_not_found()
    {
        $this->actingAs($this->user, 'sanctum');

        $this->getJson("$this->url/9999")->assertNotFound();      // show
        $this->putJson("$this->url/9999")->assertNotFound();      // update
        $this->deleteJson("$this->url/9999")->assertNotFound();   // destroy
    }

    // TODO: Add a Policy to manage access to a note resource
//    public function routes_return_forbidden_in_not_owned_note()
//    {
//        $this->actingAs($this->user, 'sanctum');
//
//        $anotherUser = User::factory()->create();
//        $notOwnedNote = Note::factory()->user($anotherUser)->create();
//
//        $this->getJson("$this->url/{$notOwnedNote->getKey()}")->assertForbidden();      // show
//        $this->putJson("$this->url/{$notOwnedNote->getKey()}")->assertForbidden();      // update
//        $this->deleteJson("$this->url/{$notOwnedNote->getKey()}")->assertForbidden();   // destroy
//    }
}
