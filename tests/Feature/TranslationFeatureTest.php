<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        return $this->actingAs($user, 'sanctum');
    }

    public function test_can_create_translation()
    {
        $this->authenticate();

        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome!',
            'tags' => ['homepage', 'greeting'],
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['key' => 'welcome_message']);
    }

    public function test_can_update_translation()
    {
        $this->authenticate();

        $translation = Translation::factory()->create();

        $response = $this->putJson("/api/translations/{$translation->id}", [
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['content' => 'Updated content']);
    }

    public function test_can_search_translation_by_key()
    {
        $this->authenticate();

        Translation::factory()->create(['key' => 'welcome_message']);

        $response = $this->getJson('/api/search?key=welcome');

        $response->assertStatus(200)
                 ->assertJsonFragment(['key' => 'welcome_message']);
    }

    public function test_can_list_all_translations()
    {
        $this->authenticate();

        Translation::factory()->count(3)->create();

        $response = $this->getJson('/api/translations');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_translation_list_performance()
    {
        $this->authenticate();

        Translation::factory()->count(100)->create();

        $start = microtime(true);

        $response = $this->getJson('/api/translations');

        $duration = microtime(true) - $start;

        $response->assertStatus(200);

        // Fail test if it takes more than 500ms
        $this->assertLessThan(0.5, $duration, 'Translation list took too long to respond.');
    }

}
