<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;


class VoyagesController extends AbstractController
{
    #[Route('/voyages', name: 'voyages')]
    public function index(VisiteRepository $repository): Response
    {
        $visites = $repository->findAll();

        return $this->render('pages/voyages.html.twig', [
            'visites' => $visites,
        ]);
    }
}