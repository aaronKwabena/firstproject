<?php

namespace App\Controller;

use App\Entity\Igredient;
use App\Form\IgredientType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IgredientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IgredientController extends AbstractController
{
    /**
     * This function displays all ingredients
     *
     * @param IgredientRepository $igredientRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
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
    
    #[Route('/igredient/nouveau',name:'app_igredient_new',methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager):Response
    {
        $igredient = new Igredient();
        $form = $this->createForm(IgredientType::class, $igredient);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $igredient = $form->getData();
            $manager ->persist($igredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été créé avec succès !'
            );

            return $this->redirectToRoute('app_igredient');
        }


        return $this->render('pages/igredient/new.html.twig', [
            'form'  => $form->createView()
        ]);

    }

    #[Route('/igredient/edition/{id}','app_igredient_edit', methods:['GET','POST'])]
    public function edit(IgredientRepository $igredientRepository, int $id, Request $request, EntityManagerInterface $manager) : Response
    {
        
        $igredient = $igredientRepository->findOneBy(["id"=>$id]);
        
        $form = $this->createForm(IgredientType::class, $igredient);

        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $igredient = $form->getData();

            $manager ->persist($igredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_igredient');

        }

        return $this->render('pages/igredient/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/igredient/suppression/{id}', 'app_igredient_delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager,int $id,IgredientRepository $igredientRepository) : Response
    {
        $igredient = $igredientRepository->findOneBy(["id" => $id]);

        //vérification si l'ingrédient existe
        if(!$igredient){
            $this->addFlash(
                'success',
                "Votre ingredient n'a pas été trouvé !"
            );
            return $this->redirectToRoute('app_igredient');
        }

        $manager->remove($igredient);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre ingredient a été supprimé avec succès !"
        );

        return $this->redirectToRoute('app_igredient');
       
    }
}
