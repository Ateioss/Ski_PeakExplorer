<?php

namespace App\Controller\Admin;

use App\Entity\Piste;
use App\Entity\Remontee;

use App\Entity\StationSki;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //  return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ski PeakExplorer');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl("Administration", 'fas fa-gear', '/admin');
        yield MenuItem::linkToUrl("Une otarie qui tourne", 'fas fa-water', 'https://www.youtube.com/watch?v=eY52Zsg-KVI');
        //ajouter un espace
        yield MenuItem::section('Base de données');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Piste', 'fas fa-list', Piste::class);
        yield MenuItem::linkToCrud('Remontee', 'fas fa-list', Remontee::class);
        //   yield MenuItem::linkToCrud('Stationsowner', 'fas fa-list', StationSki::class);
    }
}
