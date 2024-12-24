<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\UseCases\EncodeUrlUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EncodeController extends Controller
{
    public function __construct(
        private readonly EncodeUrlUseCase $encodeUrlUseCase
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'url' => 'required|url',
        ]);

        $shortUrl = $this->encodeUrlUseCase->execute($data['url']);

        return response()->json([
            'short_url' => $shortUrl,
        ]);
    }
}
