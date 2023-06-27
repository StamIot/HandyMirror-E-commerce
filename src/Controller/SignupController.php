<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request); // J'écoute la requête

        if ($form->isSubmitted() && $form->isValid()) { // Si le formulaire est soumis et valide je fais un traitement
            $user = $form->getData(); // Je récupère les données du formulaire

            $this->entityManager->persist($user); // Je persiste les données pour les envoyer en BDD
            $this->entityManager->flush(); // Je flush les données 

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
