<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Qcm;
use App\Repository\QcmRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class QcmController extends AbstractController
{
    
    private $liste_qcm;
    private $om;
    
    public function __construct(QcmRepository $liste_qcm, ObjectManager $om) 
    {
        $liste_qcm = $this->liste_qcm;
        $om = $om;
    }
    
    //Fonction qui retourne la page avec les derniers QCM mis en ligne
    public function index(QcmRepository $qcm): Response
    {   
        $latest_qcm = $qcm->findLatest();
        
        return $this->render('pages/afficherQCM.html.twig', [
            'latest_qcm' => $latest_qcm    
        ]);
    }
    
    //Fonction qui retourne la page d'un QCM sélectionné
    public function show(Qcm $qcm, string $slug): Response 
    {
        if ($qcm->getSlug() !== $slug) 
        {
            $this-> redirectToRoute('show', [
                'id' => $qcm->getIdQcm(),
                'slug' => $qcm->getSlug()
            ], 301);    
        }
        return $this->render('pages/show.html.twig', [
            'qcm' => $qcm
        ]);
    }
    
}