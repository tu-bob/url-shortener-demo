<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Url as UrlModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DecodeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testItReturnsOriginalUrl(): void
    {
        $originalUrl = 'https://www.google.com?utm_source=short.est';
        $shortCode = 'short1';

        UrlModel::query()->create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);

        $response = $this->postJson('/api/decode', [
            'url' => 'http://short.est/short1',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'original_url',
            ]);
    }

    public function testItReturnsValidationErrors(): void
    {
        $response = $this->postJson('/api/decode', [
            'url' => 'invalid-url',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'url',
            ]);
    }

    public function testItReturnsNullWhenDecodingNonExistentUrl(): void
    {
        $response = $this->postJson('/api/decode', [
            'url' => 'http://short.est/short1',
        ]);

        $response->assertStatus(404);
    }
}
