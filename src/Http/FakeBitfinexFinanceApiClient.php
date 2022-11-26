<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class FakeBitfinexFinanceApiClient implements FinanceApiClientInterface
{

    public static $statusCode = 200;
    public static $content = '';

    public function fetchStockProfile(string $symbol): JsonResponse
    {
       return new JsonResponse(self::$content, self::$statusCode, [], $json = true);
    }
}