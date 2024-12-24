<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Url as UrlModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EncodeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testItEncodesUrl(): void
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'https://www.google.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'short_url',
            ]);

        $model = UrlModel::query()->where('original_url', 'https://www.google.com')->first();

        $this->assertNotNull($model);
        $this->assertEquals($response['short_url'], 'http://short.est/' . $model->short_code);
    }

    public function testItReturnsValidationErrors(): void
    {
        $response = $this->postJson('/api/encode', [
            'url' => 'invalid-url',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'url',
            ]);
    }

    public function testItReturnsShortenedUrlWhenUrlAlreadyExists(): void
    {
        $url = 'https://www.example.com';
        $shortCode = 'short1';

        UrlModel::query()->create([
            'original_url' => $url,
            'short_code' => $shortCode,
        ]);

        $response = $this->postJson('/api/encode', [
            'url' => $url,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'short_url',
            ])
            ->assertJson([
                'short_url' => 'http://short.est/' . $shortCode,
            ]);

        $this->assertCount(
            1,
            UrlModel::query()->where('original_url', $url)->get()
        );
    }
}
