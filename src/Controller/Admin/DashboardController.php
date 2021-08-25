<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categories;
use App\Entity\User;
use App\Entity\Products;
use App\Entity\Commande;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MobileGuy');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-arrow-left', 'home');
        yield MenuItem::linkToCrud('Products', 'fa fa-cog', Products::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-tag', Categories::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user-circle-o', User::class);
        yield MenuItem::linkToCrud('Commande', 'fa fa-shopping-basket', Commande::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}