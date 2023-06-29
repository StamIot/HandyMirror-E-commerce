<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use App\Service\HandyLogs;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignupController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/signup", name="app_signup", methods={"GET", "POST"})
     */
    public function index(Request $request, LoggerInterface $logger, HandyLogs $handyLogs): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        // J'écoute la requête et je récupère les données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $handyLogs->writeInfo("Un utilisateur est sur le point de s'inscrire sur le site");

            // Je fais mon traitement si le mail existe déjà dans la base de données
            $userExists = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $form->get('email')->getData()]); // j'intérroge la base de données pour savoir si l'email existe déjà
            if ($userExists) {
                $logger->error('Un utilisateur avec cette adresse email existe déjà');
                $handyLogs->writeError("Un utilisateur avec cette adresse email existe déjà");
                $this->addFlash('error', 'Un utilisateur avec cette adresse email existe déjà'); // j'envoie un message flash à la vue 
                return $this->redirectToRoute('app_signup');
            } 

            // Je fais mon traitement pour vérifier si les mot de passe son identique
            if ($form->get('password')->getData() !== $form->get('password_confirm')->getData()) { 
                $logger->error('Les mots de passe ne correspondent pas');
                $handyLogs->writeError("Les mots de passe ne correspondent pas");
                $this->addFlash('error', 'Les mots de passe ne correspondent pas'); // Ici aussi j'envoie un message flash à la vue
                return $this->redirectToRoute('app_signup');
            }

            // Si tout se passe bien je fais un hash du mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            // Ici j'utilise le service de log par HandiMirror pour dire q'un utilisateur vient de s'inscrire dans les logs
            $logger->notice('Un utilisateur vient de s\'inscrire');
            $handyLogs->writeSuccess("Un utilisateur vient de s'inscrire sur le site");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('signup/index.html.twig', [
            'titlePage' => "S'inscrire",
            'formSignup' => $form->createView()
        ]);
    }

    /**
     * @Route("/signup/success", name="app_success_signup")
     */
    public function success(): Response
    {
        return $this->render('home/index.html.twig', [
            'titlePage' => 'handy mirror',
        ]);
    }
}
