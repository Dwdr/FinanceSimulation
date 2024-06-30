<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
  use RefreshDatabase;

  /**
     * A basic feature test example.
     *
     * @return void
     */
  public function testRegisterPage()
  {
    $response = $this->get(route('register'));
    $response->assertSuccessful();
  }

  public function testRegister()
  {
    $user = factory(User::class)->make();
    $response = $this->post(route('register'), [
      'name' => $user->name,
      'email' => $user->email,
      'password' => 'password',
      'password_confirmation' => 'password',
    ]);
    $response->assertRedirect(route('home'));
    $this->assertDatabaseHas('users', [
      'name' => $user->name,
      'email' => $user->email,
    ]);
    $this->assertTrue(
      Hash::check('password', User::where('email', $user->email)->first()->password)
    );
  }

  public function testLoginPage()
  {
    $response = $this->get(route('login'));
    $response->assertSuccessful();
  }

  public function testLogin()
  {
    $user = factory(User::class)->create();
    $response = $this->post(route('login'), [
      'email' => $user->email,
      'password' => 'password',
    ]);
    $response->assertRedirect(route('home'));
    $response->assertTrue(Auth::check());
  }

}
