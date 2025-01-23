<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;


class CategoryController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository $repo
    ) {}

    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
    
        return $this->render('category/index.html.twig', [
            'categories' => $this->repo->findAll()
        ]);
    }
    
    #[Route('/categorie/{id}', name: 'app_category')]
    public function show(int $id): Response
    {
    
        return $this->render('category/category.html.twig', [
            'category' => $this->repo->find($id)
        ]);
    }
}