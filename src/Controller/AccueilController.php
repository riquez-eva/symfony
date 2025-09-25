<?php

namespace App\Controller;

use App\Repository\DiscRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(DiscRepository $repo): Response
    {

        $discs = $repo -> findAll();
        return $this->render('accueil/accueil.html.twig', [
            "discs"=>$discs
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
         $info = ['lastname' => 'Loper', 'firstname' => 'Dave', 'email' => 'daveloper@code.dom', 'birthdate' => '01/01/1970'];
        return $this->render('accueil/contact.html.twig', [
            'controller_name' => 'AccueilController',
            'informations' => $info
        ]);
    }
}
