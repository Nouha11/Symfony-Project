<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/test/{name}/{pren}', name: 'app_showService')]
    public function showService($name,$pren): Response
    {
        //return new Response('<h1>Bonjour ' . $name .' '. $pren . '!</h1>');
        return $this->render('service/showService.html.twig', ['n' => $name,'pren' => $pren]);
    }

    #[Route('/go', name: 'app_gotoHome')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('App_home');
    }

}
