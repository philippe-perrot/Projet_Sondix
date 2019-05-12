<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Repository\ChoixRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use App\Repository\ResultatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Qcm;
use App\Repository\QcmRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class QcmController extends AbstractController
{
    
    private $liste_qcm;
    private $liste_question;
    private $liste_reponse;
    private $om;
    
    public function __construct(QcmRepository $liste_qcm, QuestionRepository $liste_question , ReponseRepository $liste_reponse ,ObjectManager $om)
    {
        $liste_qcm = $this->liste_qcm;
        $liste_question = $this->liste_question;
        $liste_reponse = $this->liste_reponse;
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

    public function response(Qcm $qcm, QuestionRepository $liste_question, ReponseRepository $liste_reponse, string $slug): Response
    {
        if ($qcm->getSlug() !== $slug)
        {
            $this-> redirectToRoute('/qcm/repondre/{slug}-{id}', [
                'id' => $qcm->getIdQcm(),
                'slug' => $qcm->getSlug()
            ], 301);
        }
        $liste_question = $liste_question->getQuestions($qcm->getIdQcm());
        foreach ($liste_question as $question) {
            $questions[] = $question->getId();
        }
        $liste_reponse = $liste_reponse->getReponses($questions);

        return $this->render('pages/response.html.twig', [
            'qcm' => $qcm,
            'liste_questions' => $liste_question,
            'liste_reponses' => $liste_reponse
        ]);
    }

    //Permet de modifier un QCM
    public function submit(Qcm $qcm, ResultatRepository $resultat, ChoixRepository $choix, ReponseRepository $bonne_reponse, string $slug)
    {
        /*
        $form = $this->createForm(QcmType::class, $qcm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Le QCM a bien été modifié');
            return $this->redirectToRoute('index');
        }

        return $this->render('admin/edit.html.twig', [
            'qcm' => $qcm,
            'form' => $form->createView()
        ]);
        */
        //foreach ($_POST['question'] as $q) {
        //    echo ($q);
        //}
        $score = 0;
        if ($qcm->getSlug() !== $slug)
        {
            $this-> redirectToRoute('/qcm/repondre/{slug}-{id}', [
                'id' => $qcm->getIdQcm(),
                'slug' => $qcm->getSlug()
            ], 301);
        }
        $id_quest = [];
        foreach ($_POST['question'] as $q) {
            array_push($id_quest, $q);
        }
        $correcte = $bonne_reponse->getBonnesReponses($id_quest);
        $tab_bonneReponse = [];
        foreach ($correcte as $c) {
            $b = $c->getValeur();
            array_push($tab_bonneReponse, $b);
        }
        $max = count($tab_bonneReponse);
        if (isset($_POST['question'])) {
            $resultat->createResult('1', $qcm->getIdQcm());
            $result = $resultat->getIdResult($qcm->getIdQcm());
            $id_result = 1;
            foreach ($result as $res) {
                $id_result = $res->getId();
            }
            foreach ($_POST['question'] as $q) {
                if (isset($_POST['reponse'.$q])) {
                    foreach ($_POST['reponse'.$q] as $r) {
                        $choix->createChoice($id_result, $q, $_POST[$r]);
                        if(in_array($r, $tab_bonneReponse)) {
                            $score++;
                        } else {
                            $score--;
                        }
                    }
                }
            }
            if($score < 0) {
                $score = 0;
            }
            $resultat->setScore($id_result, $score);
        }


        return $this->render('pages/result.html.twig', [
            'qcm' => $qcm,
            'score' => $score,
            'max' => $max
        ]);

    }

}