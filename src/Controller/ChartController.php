<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ChartController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/", "app_chart_page")
     */
    public function index() {
        return $this->render('chart/index.html.twig');
    }

}