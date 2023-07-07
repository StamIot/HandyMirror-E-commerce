<?php

namespace App\Controller\Admin;

use App\Controller\ProductController;
use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Command;
use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        // return $this->render('admin/connect-to-my-dashboard.html.twig');
        return $this->render('admin/panel-admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('HandyMirror E Commerce Client');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToUrl('Retour sur la boutique', 'fas fa-shopping-cart', '/products/list'),

            MenuItem::section('Section - Clients'),
            MenuItem::linkToCrud('Client inscrit', 'fa-solid fa-arrow-right', User::class),
            MenuItem::linkToCrud("Adresse", 'fa-solid fa-arrow-right', Address::class),
            MenuItem::linkToCrud('Commande passé', 'fa-solid fa-arrow-right', Command::class),

            MenuItem::section('Section - Produits'),
            MenuItem::linkToCrud('Catégories', 'fa-solid fa-arrow-right', Category::class),
            MenuItem::linkToCrud('Produits', 'fa-solid fa-arrow-right', Product::class)
        ];
    }
}
