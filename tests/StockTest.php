<?php

namespace App\Tests;

use App\Entity\Stock;
use App\Tests\integration\DatabaseDependantTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StockTest extends DatabaseDependantTestCase {

    /** @test */
    public function stock_record_db_creation() {

        // Set up

        // Stock
      $stock = new Stock();
      $stock->setSymbol('BTCUSD');
      $stock->setMid('16559.5');
      $stock->setBid('16559.0');
      $stock->setAsk('16560.0');
      $stock->setLastPrice('16560.0');
      $stock->setLow('16444.0');
      $stock->setHigh('16811.0');
      $stock->setVolume('961.02288135');
//      $stock->setTimestamp('null');

      $this->entityManager->persist($stock);
      $this->entityManager->flush();
      $stockRepository = $this->entityManager->getRepository(Stock::class);
      $stockRecord = $stockRepository->findOneBy(['symbol' => 'BTCUSD']);
      $this->assertEquals('16559.5', $stockRecord->getMid());
    }
}
