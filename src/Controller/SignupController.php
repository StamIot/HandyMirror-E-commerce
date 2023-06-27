<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) // J'injecte l'entity manager dans le constructeur
    {
        $this->entityManager = $entityManager; // Je créee une variable qui va contenir l'entity manager
    }

    #[Route('/signup', name: 'app_signup', methods: ['GET', 'POST'])] // dans la route, je précise que la méthode est GET et POST
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        // $infoController = new ReflectionClass($user);
        // dd($infoController->getMethods());

        // $logger->alert('Un utilisateur est en train de s\'inscrire'); // J'envoie un message dans le fichier de log (var/log/dev.log
        // $logger->notice("------------------------ Je fais un test de log ------------------------- "); // J'envoie un message dans le fichier de log (var/log/dev.log

        $form->handleRequest($request); // J'écoute la requête

        if ($form->isSubmitted() && $form->isValid()) {
            // Traite la confirmation du mot de passe
            if ($form->get('password')->getData() !== $form->get('password_confirm')->getData()) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas');
                $logger->error('Les mots de passe ne correspondent pas');
                return $this->redirectToRoute('app_signup');
            }
        
            // Je hash le mot de passe pour la sécurité dans la base de données
            $user->setPassword(
                password_hash(
                    $form->get('password')->getData(),
                    PASSWORD_BCRYPT
                )
            );

            $user = $form->getData(); // Je récupère les données du formulaire

            $this->entityManager->persist($user); // Je persiste les données pour les envoyer en BDD
            $this->entityManager->flush(); // Je flush les données 

            $logger->notice('Un utilisateur vient de s\'inscrire'); // J'envoie un message dans le fichier de log (var/log/dev.log

            return $this->redirectToRoute('app_home'); // Je redirige vers la route d'accueil
        }

        return $this->render('signup/index.html.twig', [ // Je retourne la vue signup/index.html.twig
            'titlePage' => "S'inscrire",
            'formSignup' => $form->createView() 
        ]);
    }

    #[Route('/signup/success', name: 'app_home')] // en cas de succès, je redirige vers la route d'accueil
    
    public function success(): Response
    {
        return $this->render('home/index.html.twig', [
            'titlePage' => 'handy mirror',
        ]);
    }

  }

