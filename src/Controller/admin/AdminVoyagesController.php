<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

/**
 * Description of AdminVoyagesController
 *
 * @author SlameX
 */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VisiteType;

class AdminVoyagesController extends AbstractController {
    
    #[Route('/admin', name: 'admin.voyages')]
    public function index(VisiteRepository $repository): Response
    {
        $visites = $repository->findAllOrderBy('datecreation','DESC');

        return $this->render('admin/admin.voyages.html.twig', [
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
    public function findAllEqual ($champ, Request $request ,VisiteRepository $repository):Response{
        
        $valeur = $request->get("recherche");
        $visites = $repository->findByEqualValue($champ, $valeur);
        return $this->render("pages/voyages.html.twig",[
            'visites'=> $visites
        ]);
    }
    #[Route('voyages/voyage/{id}',name:'voyages.showone')]
    public function showOne($id, VisiteRepository $repository) :Response{
        
        $visite = $repository->find($id);
        return $this->render("pages/voyage.html.twig",[
                'visite'=>$visite
                ]);
    }
    
    #[Route('/admin/suppr/{id}', name:'admin.voyage.suppr')]
    public function suppr( $id, VisiteRepository $repository) : Response {
        $visite = $repository->find($id);
        $repository->remove($visite);
        return $this->redirectToRoute('admin.voyages');
        
    }
    #[Route('/admin/edit/{id}',name:'admin.voyage.edit')]
    public function edit ($id, VisiteRepository $repository,Request $request) :Response{
        $visite = $repository->find($id);
        $formvisite = $this->createForm(VisiteType::class, $visite);
        
        $formvisite->handleRequest($request);
        if($formvisite->isSubmitted()&& $formvisite->isValid()){
            $repository->add($visite);
            return $this->redirectToRoute('admin.voyages');
        }
        return $this->render('admin/admin.voyage.edit.html.twig',[
            'visite'=>$visite,
            'formvisite'=>$formvisite->createView()
        ]);
    }
    
}
