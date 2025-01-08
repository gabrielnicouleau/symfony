<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', []);
    }
    #[Route('/name/{nom}', name:'app_accueil_affichage')]
    public function affichage(string $nom): Response{
        return new response ("texte, ".$nom);
    }
    #[Route("/addition/{num1}/{num2}", name:"app_accueil_addition")]
    public function addition(int $num1, int $num2): Response{
        $somme = $num1 + $num2;
        if ($num1 < 0 || $num2 < 0) {
            return new response ("<p>Les nombres sont négatifs</p>");
        } else {
            return new response ("<p>L'addition de ".$num1." et ".$num2." est égal au résultat: ".$somme."</p>");
        }
    }
}
