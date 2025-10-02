<?php

namespace App\Controller;


use App\Form\TestType;
use App\Form\DiscType;
use App\Entity\Disc;
use App\Repository\DiscRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #Pour la page d'accueil, ou il y a la liste des disques et le nombre de ces derniers
    #[Route('/accueil', name: 'app_accueil')]
    public function index(DiscRepository $repo): Response
    {

        $discs = $repo -> findAll();
        $DiscTotal = $repo->countDisc();
        return $this->render('accueil/accueil.html.twig', [
            "discs"=>$discs,
            'totalDisques' => $DiscTotal
        ]);
    }
    
    #[Route('/details/{id}', name: 'app_details')]
    public function details(Disc $disc): Response
    {
        return $this->render('accueil/details.html.twig', [
            'disc' => $disc,
        ]);
    }
    #[Route('/formulaire', name: 'app_formulaire')]
    public function formulaire(Request $request, EntityManagerInterface $manager): Response
    {
        $disc = new Disc();
        $form = $this->createForm(DiscType::class, $disc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //dd($disc);

            $picture_name= $disc->getTitle().".png";
            $picture = $form->get('picture')->getData();
            $picture->move($this->getParameter('kernel.project_dir') . '/public/pictures',
    $picture_name);

            $disc->setPicture($picture_name);

            $manager->persist($disc);
            $manager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('accueil/formulaire.html.twig', [
            'form' => $form
        ]);
    }

        #[Route('/message', name: 'app_message')]
        public function message(Request $request): Response
    {

        $form = $this->createForm(TestType::class);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dd($form);

            return $this->redirect("/accueil");
        }
        return $this->render('accueil/message.html.twig', [
            "form" => $form
        ]);
    }

     #[Route('/modifier/{id}', name: 'app_modifier')]
    public function modifier(Request $request, Disc $disc, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(DiscType::class, $disc);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            return $this->redirectToRoute('app_details', ['id' => $disc->getId()]);
        }
        return $this->render('accueil/modifier.html.twig', [
            'form' => $form->createView(),
            'disc' =>$disc,
                ]);
    }

     #[Route('/details/{id}/supprimer', name: 'app_supprimer', methods:['post'])]
    public function supprimer(Request $request, Disc $disc, EntityManagerInterface $manager): Response
    {
        if($this->isCsrfTokenValid('supprimer'.$disc->getId(), $request->request->get('_token'))){
            $manager->remove($disc);
            $manager->flush();
            $this->addFlash('success', 'Le disque a bien été supprimé.');
        }
        return $this->redirectToRoute('app_accueil');
    }
}
