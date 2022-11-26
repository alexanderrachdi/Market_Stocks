<?php

namespace App\Tests\integration;

class BitfinexFinanceApiClientTest extends DatabaseDependantTestCase
{
    /**
     * @test
     * @group integration
     */
    public function bitfinex_finance_api_returns_correct_data() {

        $bitfinexFinanceApiClient = self::$kernel->getContainer()->get('bitfinex-finance-api-client');

        $responce = $bitfinexFinanceApiClient->fetchStockProfile('BTCUSD');

        $stockProfile = json_decode($responce->getContent());

        $this->assertSame('BTCUSD', $stockProfile->symbol);
        $this->assertEquals(200, $responce->getStatusCode());
    }
}