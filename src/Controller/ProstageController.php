<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProstageController extends AbstractController
{
    /**
     * @Route("/prostage", name="prostage")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'ProstageController',
        ]);
    }
}
