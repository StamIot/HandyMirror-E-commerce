<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController
{
    #[Route('/send-email', name: 'send_email')]
    public function sendEmail(MailerInterface $mailer)
    {
        try {
            $email = (new Email())
                ->from('handymirrorproject@gmail.com')
                ->to('sophiemajorel@hotmail.fr')
                ->subject('RECLAMATION - 2022 ')
                ->text('BONSOUAAAR PARIS YEEEAAH.');

            $mailer->send($email);

            return $this->render('email/sent.html.twig');
        } catch (\Exception $e) {
            // Gérer l'exception ici
            $errorMessage = 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail : ' . $e->getMessage();
            // Vous pouvez ajouter d'autres actions à effectuer en cas d'erreur, telles que l'enregistrement de l'erreur dans un journal ou l'affichage d'un message d'erreur personnalisé.

            return $this->render('email/error.html.twig', [
                'errorMessage' => $errorMessage,
            ]);
        }
    }
}
