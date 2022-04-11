<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $this->postJson(route('user.register'),[
            'name' => 'J', 
            'email' => 'sephelegipto@gmail.com', 
            'password' => 'admin123',
            'password_confirmation' => 'admin123'
        ])
            ->assertCreated();

        $this->assertDatabaseHas('users', ['name' => 'J']);
    }
}
