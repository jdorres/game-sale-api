<?php

namespace Tests\Feature\Services;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

#php artisan test --filter=UserControllerTest
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexIsReturningCorrectData(){
        //ARRANGE
        User::factory()->count(3)->create();
        //ACT
        $response = $this->getJson('api/users');
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJsonCount(3);
    }

    public function testStore(){
        //ARRANGE
        $userData = [
            'name'      => 'João Moreira',
            'document'  => '12345678912',
            'email'     => 'joao@teste.com.br',
            'phone'     => '+5551999999999',
            'password'  => 'senha123',
        ];
        //ACT
        $response = $this->postJson('api/users', $userData);
        //ASSERT
        unset($userData['password']);
        $response->assertStatus(Response::HTTP_CREATED)
                    ->assertJson($userData);
        $this->assertDatabaseHas('users', $userData);
    }

    public function testShow(){
        //ARRANGE
        $userData = [
            'name'      => 'João Moreira',
            'document'  => '12345678912',
            'email'     => 'joao@teste.com.br',
            'phone'     => '+5551999999999',
            'password'  => 'senha123',
        ];
        $user = User::create($userData);
        //ACT
        $response = $this->getJson("api/users/{$user->id}");
        //ASSERT
        unset($userData['password']);
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJson($userData);
    }

    public function testUpdate(){
        //ARRANGE
        $user = User::factory()->create();
        $userData = [
            'name'      => 'João Moreira',
            'document'  => '12345678912',
            'email'     => 'joao@teste.com.br',
            'phone'     => '+5551999999999'
        ];
        //ACT
        $response = $this->postJson("api/users/{$user->id}", $userData);
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJson($userData);
    }

    public function testDestroy(){
        //ARRANGE
        $user = User::factory()->create();
        //ACT
        $response = $this->deleteJson("api/users/{$user->id}");
        //ASSERT
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('users', $user->getAttributes());
    }
}
