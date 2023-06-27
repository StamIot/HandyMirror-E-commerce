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

    #[Route('/signup', name: 'app_signup', methods: ['GET', 'POST'])]
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traite la confirmation du mot de passe
            if ($form->get('password')->getData() !== $form->get('password_confirm')->getData()) { // Si les mots de passe ne correspondent pas
                $this->addFlash('error', 'Les mots de passe ne correspondent pas'); // Ajoute un message flash
                $logger->error('Les mots de passe ne correspondent pas'); // Log l'erreur
                return $this->redirectToRoute('app_signup'); // Redirige vers la page d'inscription
            }

            $hashedPassword = $this->passwordHasher->hashPassword($user, $form->get('password')->getData()); // Hash le mot de passe avec hasher
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $logger->notice('Un utilisateur vient de s\'inscrire');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('signup/index.html.twig', [
            'titlePage' => "S'inscrire",
            'formSignup' => $form->createView()
        ]);
    }

    #[Route('/signup/success', name: 'app_success_signup')]
    public function success(): Response
    {
        return $this->render('home/index.html.twig', [
            'titlePage' => 'handy mirror',
        ]);
    }
}
