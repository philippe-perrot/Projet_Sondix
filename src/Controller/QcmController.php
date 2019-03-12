<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Qcm;
use App\Repository\QcmRepository;
use Doctrine\Common\Persistence\ObjectManager;

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
        $lastest_qcm = $qcm->findLatest();
        
        return $this->render('pages/afficherQCM.html.twig', [
            'latest_qcm' => $lastest_qcm    
        ]);
    }
    
}