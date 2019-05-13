<?php
namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

    private $personne;
    private $em;

    public function __construct(PersonneRepository $personne, ObjectManager $em)
    {
        $this->personne = $personne;
        $this->em = $em;
    }

    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    //Permet de créer un nouveau QCM
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($personne, $personne->getMdp());
            $personne->setMdp($password);
            $this->em->persist($personne);
            $this->em->flush();
            $this->addFlash('success', 'Votre compte a bien été créé');
            $token = new UsernamePasswordToken($personne, null, 'main', $personne->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));
            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', [
            'personne' => $personne,
            'form' => $form->createView()
        ]);

    }

}