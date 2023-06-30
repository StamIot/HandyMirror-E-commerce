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

    #[Route('/signup', name: "app_signup", methods: ["GET", "POST"])]
    public function index(Request $request, LoggerInterface $logger, HandyLogs $handyLogs): Response
    {
        $user = new User();
        $form = $this->createForm(SignupType::class, $user);

        // J'écoute la requête du formulaire
        $form->handleRequest($request);

        // dd($form->getData());

        if ($form->isSubmitted() && $form->isValid()) {

            $logger->info("Un nouvel utilisateur est sur le point de s'inscrire sur le site"); // Logger (Terminal)
            $handyLogs->writeInfo("Un nouvel utilisateur est sur le point de s'inscrire sur le site"); // HandyLogs (Fichier)

            // Vérification de l'existance du mail dans la base de données
            $userExist = $this->entityManager->getRepository(User::class)->findOneBy(
                ['email' => $form->get('email')->getData()]
            );

            // Je fais mon traitement si le mail existe déjà dans la base de données
            $userExists = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $form->get('email')->getData()]); // j'intérroge la base de données pour savoir si l'email existe déjà
            if ($userExists) {
                $message = "Le nouvel utilisateur dispose déjà de cette adresse e-mail (" . $form->get('email')->getData() . "). Inscription annulé.";

                $logger->error($message); // Logger (Terminal)
                $handyLogs->writeError($message); // HandyLogs (Fichier)
              
                // J'utilise le système de notification pour dire que l'email existe déjà
                toastr()
                    ->positionClass('toast-top-full-width')
                    ->timeOut("5000")
                    ->preventDuplicates(true)
                    ->tapToDismiss(true)
                    ->addWarning("<strong style='color: #333333;'>" . $user->getEmail() . "</strong> existe déjà dans la base de données");

                return $this->redirectToRoute('app_signup');
            }

            // Vérification de la conformité des deux mots de passes.
            if (
                $form->get('password')->getData() !==
                $form->get('password_confirm')->getData()
            ) {
                // Logger (Terminal)
                $logger->error('Les mots de passe ne correspondent pas');
                // HandyLogs (Fichier)
                $handyLogs->writeError("Les mots de passe ne correspondent pas");
                // $this->addFlash('error', 'Les mots de passe ne correspondent pas'); // Ici aussi j'envoie un message flash à la vue

                // J'utilise le toastr pour dire que les mots de passe ne correspondent pas
                toastr()
                    ->positionClass('toast-top-full-width')
                    ->timeOut("5000")
                    ->preventDuplicates(true)
                    ->tapToDismiss(true)
                    ->addError("<strong style='color: #333333;'>" . $user->getFirstname() . "</strong>, tes mots de passe ne correspondent pas");

                return $this->redirectToRoute('app_signup');
            }

            // Tout est OK ici, hash du mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

              $logger->notice(
                $form->get("firstname")->getData() . " " . $form->get("lastname")->getData() . " vient de s'inscrire"
            ); // Logger (Terminal)
            $handyLogs->writeSuccess(
                $form->get("firstname")->getData() . " " . $form->get("lastname")->getData() . " vient de s'inscrire"
            ); // HandyLogs (Fichier)
  
            toastr()
                ->positionClass('toast-top-full-width')
                ->timeOut("5000")
                ->preventDuplicates(true)
                ->tapToDismiss(true)
                ->addSuccess("<strong style='color: white;'>" . $user->getFirstname() . "</strong>, la création de ton compte a bien été effectuée.");

            toastr()
                ->positionClass('toast-top-full-width')
                ->timeOut("5000")
                ->preventDuplicates(true)
                ->tapToDismiss(true)
                ->addInfo("<strong style='color: white;'>" . $user->getFirstname() . "</strong>, tu peux te connecter maintenant.");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('signup/index.html.twig', [
            'titlePage' => "Inscription",
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
