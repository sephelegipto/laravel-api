<?php

namespace Tests\Feature;

use App\Models\BibleverseList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BibleVerseTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp():void{
        parent::setup();
        $user = $this->authUser();
        $this->list = BibleverseList::factory()->create([
            'verses' => 'test verses', 'user_id' => $user->id
        ]);
    }

    public function test_fetch_all_bibleverse_list()
    {
        $this->createBibleVerse();
        $response = $this->getJson(route('bibleverse-list.index'));
        $this->assertEquals(2, count($response->json()));
    }

    public function test_fetch_single_bibleverse_list()
    {
        $response = $this->getJson(route('bibleverse-list.show', $this->list))
                    ->assertOk()
                    ->json();
        $this->assertEquals($response['verses'], $this->list->verses);
    }

    public function test_store_new_bibleverse_list()
    {
        $response = $this->postJson(route('bibleverse-list.store'), ['verses' => "test 2"])
            ->assertSuccessful()
            ->json();
        $this->assertEquals('test 2', $response['verses']);
        $this->assertDatabaseHas('bibleverse_lists', ['verses' => "test 2"]);
    }

    public function test_while_storing_bibleverse_list_verses_field_is_required()
    {
        $this->withExceptionHandling();
        $this->postJson(route('bibleverse-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['verses']);
    }

    public function test_delete_bibleverse_list(){
        $this->deleteJson(route('bibleverse-list.destroy', $this->list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('bibleverse_lists', ['verses' => $this->list->name]);
    }

    public function test_update_bibleverse_list(){
        $this->patchJson(route('bibleverse-list.update', $this->list->id),['verses' => 'updated verses'])
            ->assertOk();

        $this->assertDatabaseHas('bibleverse_lists', ['id' => $this->list->id, 'verses' => 'updated verses']);
    }

    public function test_while_updating_bibleverse_list_verses_field_is_required()
    {
        $this->withExceptionHandling();
        $this->patchJson(route('bibleverse-list.update', $this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['verses']);
    }
}
