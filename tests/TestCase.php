<?php

namespace Tests;

use App\Models\BibleverseList;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    public function setUp(): void{
         parent::setUp();
         $this->withoutExceptionHandling();
    }

    public function createBibleVerse($args = [])
    {
        return BibleverseList::factory()->create($args);
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }
}
