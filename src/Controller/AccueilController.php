<?php

namespace App\Controller;

use App\Form\DiscType;
use App\Entity\Disc;
use App\Repository\DiscRepository;
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
    
    #Pour l'instant c'est un essai mais ca ne fonctionne pas
    #[Route('/disc_details/{id}', name: 'app_details')]
    public function details(Disc $disc): Response
    {
        return $this->render('accueil/details.html.twig', [
            'disc' => $disc,
        ]);
    }
    #[Route('/formulaire', name: 'app_formulaire')]
    public function formulaire(Request $request): Response
    {
        $disc = new Disc();
        $form = $this->createForm(DiscType::class, $disc);
        $form->handlerequest($request);

        if ($form->isSubmitted()){
            dd($form);
        }

        return $this->render('accueil/formulaire.html.twig', [
            'form' => $form
        ]);
    }

}
