<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Domain\Entity\Url;
use App\Domain\Repositories\UrlRepository;
use App\Domain\Services\RandomUrlShortener;
use App\Exceptions\Domain\Repositories\DuplicateShortCodeException;
use App\Models\Url as UrlModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class RandomUrlShortenerTest extends TestCase
{
    use DatabaseTransactions;

    private readonly RandomUrlShortener $urlShortener;

    public function setUp(): void
    {
        parent::setUp();
        $this->urlShortener = app(RandomUrlShortener::class);
    }

    public function testItEncodesUrl(): void
    {
        $url = 'https://www.example.com';
        $encodedUrl = $this->urlShortener->encode($url);
        $shortCode = substr($encodedUrl, strrpos($encodedUrl, '/') + 1);
        $this->assertDatabaseHas('urls', ['short_code' => $shortCode]);
    }

    public function testItDecodesUrl(): void
    {
        $shortCode = 'abc123';
        $originalUrl = 'https://www.example.com';

        UrlModel::query()->create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);

        $decodedUrl = $this->urlShortener->decode('http://short.est/' . $shortCode);

        $this->assertEquals($originalUrl, $decodedUrl);
    }

    public function testItReturnsNullWhenDecodingNonExistentUrl(): void
    {
        $decodedUrl = $this->urlShortener->decode('http://short.est/abc123');
        $this->assertNull($decodedUrl);
    }

    public function testItReturnsShortenedUrlWhenUrlAlreadyExists(): void
    {
        $url = 'https://www.example.com';
        $shortCode = 'short1';

        UrlModel::query()->create([
            'original_url' => $url,
            'short_code' => $shortCode,
        ]);

        $encodedUrl = $this->urlShortener->encode($url);
        $this->assertEquals('http://short.est/' . $shortCode, $encodedUrl);
    }

    /**
     * @throws Exception
     */
    public function testItRegeneratesCodeOnUniqueConstraintViolation(): void
    {
        $repository = $this->createMock(UrlRepository::class);
        $shortener = new RandomUrlShortener($repository);

        $url = 'https://www.example.com';
        $shortCode = 'short1';

        $repository->expects($this->exactly(2))
            ->method('save')
            ->willReturnOnConsecutiveCalls(
                $this->throwException(new DuplicateShortCodeException($shortCode)),
                new Url(id: 1, originalUrl: $url, shortCode: $shortCode)
            );

        $shortener->encode($url);
    }
}
