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
use Symfony\Component\HttpFoundation\Request;


class VoyagesController extends AbstractController
{
    #[Route('/voyages', name: 'voyages')]
    public function index(VisiteRepository $repository): Response
    {
        $visites = $repository->findAllOrderBy('datecreation','DESC');

        return $this->render('pages/voyages.html.twig', [
            'visites' => $visites,
        ]);
    }
    #[Route('/voyages/tri/{champ}/{ordre}', name: 'voyages.sort')]
    public function sort($champ, $ordre,VisiteRepository $repository):Response {
        
        $visites=$repository->findAllOrderBy($champ, $ordre);
        return $this->render("pages/voyages.html.twig",[
        'visites'=>$visites
        ]);   
    }
    #[Route('/voyages/recherche/{champ}', name: 'voyages.findallequal')]
    Public function findAllEqual ($champ, Request $request):Response{
        $valeur = $request->get("recherche");
        $visites =  $this->repository->findByEqualValue($champ, $valeur);
        return $this->render("pages/voyages.html.twig",[
            'visites'=> $visites
        ]);
    }
}