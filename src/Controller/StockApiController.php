<?php

namespace App\Controller;

use App\Entity\Stock;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockApiController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("api/fetchStock", name="fetchStock")
     */
    public function fetchStock(ManagerRegistry $doctrine): Response {

        $stox = $doctrine->getRepository(Stock::class)->findAll();

        return $this->json($stox);
    }

}