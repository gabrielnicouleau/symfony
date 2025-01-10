<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/page/{variable}', name: 'app_page')]
    public function index(string $variable): Response
    {
        return $this->render('page/index.html.twig', [
            'variable'=> $variable
        ]);
    }
}
