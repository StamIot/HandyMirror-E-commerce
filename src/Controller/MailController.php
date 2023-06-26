<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController
{
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('handymirrorproject@gmail.com')
            ->to('sophiemajorel@hotmail.fr')
            ->subject('RECLAMATION - 2022 ')
            ->text('BONSOUAAAR PARIS YEEEAAH.');

        $mailer->send($email);

        return $this->render('email/sent.html.twig');
    }
}
