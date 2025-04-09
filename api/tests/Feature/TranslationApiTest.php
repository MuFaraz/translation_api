<?php

namespace Tests\Feature;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TranslationApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_can_list_translations()
    {
        $user = User::factory()->create(); // create a test user
        $this->actingAs($user, 'api');     // authenticate the request

        Translation::factory()->count(10)->create();

        $response = $this->getJson('/api/translations');

        $response->assertStatus(200)
            ->assertJsonCount(20, 'data');
    }
}
