<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'App_home')]
    public function index():Response
    {
        return new Response('<h1>Hello World!</h1>');
    }

    /*#[Route('/gotoHome', name: 'app_gotoHome')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_showService');
    }*/
}

?>