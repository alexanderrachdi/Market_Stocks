<?php

namespace App\Controller;

use App\Entity\UserAlert;
use App\Form\UserAlertFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class UserAlertController extends AbstractController
{

    public function show(Environment $twig) {
        $user = new UserAlert();

        $form = $this->createForm(UserAlertFormType::class, $user);

        return new Response($twig->render('chart/index.html.twig', [
            'user_alert_form' => $form->createView()
        ]));
    }
}