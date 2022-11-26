<?php

namespace App\Tests\feature;

use App\Entity\Stock;
use App\Http\FakeBitfinexFinanceApiClient;
use App\Tests\DatabasePrimer;
use App\Tests\integration\DatabaseDependantTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RefreshStocksProfileCommandTest extends DatabaseDependantTestCase
{

    /** @test */
    public function refresh_stock_profile_correctly() {
        $application = new Application(self::$kernel);

        $command = $application->find('app:refresh-stock-profile');

        $commandTester = new CommandTester($command);

        FakeBitfinexFinanceApiClient::$content = '{"symbol":"BTCUSD","mid":"16198.5","bid":"16198.0","ask":"16199.0","lastPrice":"16192.0","low":"15890.0","high":"16610.0","volume":"2315.57717912"}';

        $commandTester->execute([
           'symbol' => 'BTCUSD'
        ]);

        $repo = $this->entityManager->getRepository(Stock::class);

        /** @var Stock $stock */
        $stock = $repo->findOneBy(['symbol' => 'BTCUSD']);

        $this->assertSame('BTCUSD', $stock->getSymbol());
        $this->assertGreaterThan(10000, $stock->getLow());

    }

    /** @test */
    public function non_200_status_responce() {

        $application = new Application(self::$kernel);

        $command = $application->find('app:refresh-stock-profile');

        $commandTester = new CommandTester($command);

        FakeBitfinexFinanceApiClient::$statusCode = 500;
        FakeBitfinexFinanceApiClient::$content = 'Finance api client error';

        $commandStatus = $commandTester->execute([
            'symbol' => 'BTCUSD'
        ]);

        $repo = $this->entityManager->getRepository(Stock::class);

        $stockRecordCount = $repo->createQueryBuilder('stock')
            ->select('count(stock.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertEquals(1, $commandStatus);
        $this->assertEquals(0, $stockRecordCount);
    }
}