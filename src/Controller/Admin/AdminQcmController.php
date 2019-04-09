<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Qcm;
use App\Repository\QcmRepository;
use App\Form\QcmType;
use Doctrine\Common\Persistence\ObjectManager;

class AdminQcmController extends AbstractController 
{
    
    private $qcm;
    private $em;
    
    public function __construct(QcmRepository $qcm, ObjectManager $em) 
    {
        $this->qcm = $qcm;
        $this->em = $em;
    }
    
    //R�cup�re tout les QCM existants
    public function index() 
    {
        $liste_qcm = $this->qcm->findAll();
        return $this->render('admin/index.html.twig', compact('liste_qcm'));
    }
    
    //Permet de cr�er un nouveau QCM
    public function new(Request $request) 
    {
        $qcm = new Qcm();
        $form = $this->createForm(QcmType::class, $qcm);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($qcm);
            $this->em->flush();
            $this->addFlash('success', 'Le QCM a bien �t� cr��');
            return $this->redirectToRoute('index');
        }
        
        return $this->render('admin/new.html.twig', [
            'qcm' => $qcm,
            'form' => $form->createView()
        ]);
        
    }
    
    //Permet de modifier un QCM
    public function edit(Qcm $qcm, Request $request) 
    {
        $form = $this->createForm(QcmType::class, $qcm);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) 
        {
              $this->em->flush();
              $this->addFlash('success', 'Le QCM a bien �t� modifi�');
              return $this->redirectToRoute('index');
        }
        
        return $this->render('admin/edit.html.twig', [
            'qcm' => $qcm,
            'form' => $form->createView()
        ]);
    }
    
    public function delete(Qcm $qcm, Request $request) 
    {
        if ($this->isCsrfTokenValid('delete' . $qcm->getIdQcm(), $request->get('_token'))) 
        {
            $this->em->remove($qcm);
            $this->em->flush();
            $this->addFlash('success', 'Le QCM a bien �t� supprim�');
        }
        return $this->redirectToRoute('index');
    }
    
}
    

