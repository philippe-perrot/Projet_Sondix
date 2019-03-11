<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Qcm;

class QcmController extends AbstractController
{
    
    //Fonction qui retourne la liste des QCM
    public function index(): Response
    {
        $qcm = new Qcm();
        $qcm->setNomQcm('1');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($qcm);
        $em->flush();
        
        return $this->render('pages/afficherQCM.html.twig', );
    }
    
    
    
}