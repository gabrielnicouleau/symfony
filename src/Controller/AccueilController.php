<?php
// utilisation du namespace afin d'éviter les erreurs liées à l'utilisation de deux class nommées de la même manière.
// namespace de la class du controlleur de l'acceuil.
namespace App\Controller;

// import des class utilisées via le namespace.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// création de la class du controlleur de la page acceuil.
class AccueilController extends AbstractController
{
    // fonction d'affichage de la template de la vue.
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', []);
    }

    // fonction affichage qui dit bonjour à un utilisateur.
    #[Route('/name/{nom}', name:'app_accueil_affichage')]
    public function affichage(string $nom): Response{
        return new response ("Bonjour, ".$nom);
    }

    // fonction pour additionner deux nombres.
    #[Route("/addition/{num1}/{num2}", name:"app_accueil_addition")]
    public function addition(int $num1, int $num2): Response{
        $somme = $num1 + $num2;
        if ($num1 < 0 || $num2 < 0) {
            return new response ("<p>Les nombres sont négatifs</p>");
        } else {
            return new response ("<p>L'addition de ".$num1." et ".$num2." est égal au résultat: ".$somme."</p>");
        }
    }

    // fonction calculatrice.
    #[Route("/calculatrice/{num1}/{operateur}/{num2}", name:"app_accueil_calculatrice")]
    public function calculatrice(mixed $num1, string $operateur, mixed $num2): response{
        if (!is_numeric($num1) || !is_numeric($num2)){
            $result = "Erreur: " .$num1 .  " ou " . $num2 . " n'est pas un nombre!";
            return new response ("<p>".$result."</p>");
        }elseif ($operateur == "add"){
            $result = "<p>Le réultat de l'addition est: ".$num1 + $num2."</p>";
        } elseif ($operateur == "sous"){
            $result = "<p>Le réultat de la soustraction est: ".$num1 - $num2."</p>";
        } elseif ($operateur == "multi") {
            $result = "<p>Le réultat de la multiplication est: ".$num1 * $num2."</p>";
        } elseif ($operateur == 'div') {
            if ($num1 == 0 || $num2 == 0) {
                $result = "Erreur: division par zéro interdite!";
            } else {
                $result = "<p>Le réultat de la division est: ".$num1 / $num2."</p>";
            }
        } else {
            $result = "Erreur: l'opérateur est incorrect!";
        }
        return new response ($result);
        // possible aussi avec le switch case plutot que if/else.
    }
}
