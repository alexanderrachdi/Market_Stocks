<?php

namespace App\Http;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitfinexFinanceApiClient implements FinanceApiClientInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    private const URL = 'https://api.bitfinex.com/v1/pubticker/';


    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchStockProfile($symbol): JsonResponse {
        $responce = $this->httpClient->request('GET', 'https://api.bitfinex.com/v1/pubticker/'.$symbol);

        // TODO handle non 200 responces
        if ($responce->getStatusCode() !== 200) {
            return new JsonResponse('Finance api client error', 400);
        }

        $stockProfile = json_decode($responce->getContent());

        $stockProfileArray = [
        'symbol' => $symbol,
        'mid' => $stockProfile->mid,
        'bid' => $stockProfile->bid,
        'ask' => $stockProfile->ask,
        'lastPrice' => $stockProfile->last_price,
        'low' => $stockProfile->low,
        'high' => $stockProfile->high,
        'volume' => $stockProfile->volume,
        'timestamp' => $stockProfile->timestamp
        ];

        return new JsonResponse($stockProfileArray, 200);

    }
}