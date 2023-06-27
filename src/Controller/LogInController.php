<?php

namespace App\Controller;

// Importez les classes nécessaires
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


class LogInController extends AbstractController
{
    private $entityManager; // Ajoutez une propriété pour EntityManager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route("/login", name: "login")]
    public function login(Request $request, SessionInterface $session, UserPasswordHasherInterface $passwordHasher)
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
    
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    
            if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
                // L'adresse e-mail ou le mot de passe ne correspond pas
                $error = "L'adresse e-mail ou le mot de passe ne correspond pas.";
        
                // Afficher l'erreur à l'utilisateur
                return $this->render('security/login.html.twig', ['error' => $error]);
            }
    
            // Générer un token d'une heure
            $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
            $session->set('_security_main', serialize($token));
    
            // Rediriger vers la page d'accueil ou une autre page
            return $this->redirectToRoute('app_home');
        }
    
        // Afficher le formulaire de connexion
        return $this->render('login/login.html.twig', ['error' => null]);
    }
}
