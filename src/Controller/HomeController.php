<?php

namespace App\Controller;

use App\Service\HandyLogs;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // public function __construct(private Filesystem $fs)
    // {
    // }

    #[Route('/', name: 'app_home')]
    public function index(HandyLogs $handylogs, LoggerInterface $logger): Response
    {
        // $handylogs->writeInfo("Je suis un message d'information");
        // $handylogs->writeWarning("Je suis un message de warning");
        // $handylogs->writeError("Je suis un message d'erreur");
        // $logger->error("BUG ------------------------");
        // $handylogs->writeSuccess("Je suis un message de succès");

        return $this->render('home/index.html.twig', [
            'titlePage' => 'handy mirror',
        ]);
    }
}
