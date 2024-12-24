<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\UseCases\DecodeUrlUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DecodeController extends Controller
{
    public function __construct(
        private readonly DecodeUrlUseCase $decodeUrlUseCase
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'url' => 'required|url',
        ]);

        $originalUrl = $this->decodeUrlUseCase->execute($data['url']);

        if ($originalUrl === null) {
            return response()->json([
                'error' => 'URL not found',
            ], 404);
        }

        return response()->json([
            'original_url' => $originalUrl,
        ]);
    }
}
