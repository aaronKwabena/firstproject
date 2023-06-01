<?php

namespace App\Controller;

use App\Entity\Igredient;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\IgredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IgredientController extends AbstractController
{
    #[Route('/igredient', name: 'app_igredient', methods:['GET'])]
    public function index(IgredientRepository $igredientRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $igredients = 

        $igredients = $paginator->paginate(
            $igredientRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/igredient/index.html.twig', [
           'igredient' => $igredients
         ]);
    }
}
