<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/Dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Le Bon Quark partie admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::linkToUrl('Liste des articles', 'fas fa-list', '/admin/articleListe',);
        yield MenuItem::linkToUrl('Liste des Utilisateures', 'fas fa-list', '/admin/userliste',);
        yield MenuItem::linkToUrl('retoure au site', 'fas fa-list', '/',);
    }

    /**
     * @Route("/admin/articleListe", name="admin_articleListe")
     */

    public function articleListe(ArticleRepository $articleRepository): Response{

        return $this->render('admin/articleListe.html.twig', [
            'articles' => $articleRepository->findAll(),
            
        ]);

    }

    /**
     * @Route("/admin/userliste", name="admin_userliste", methods={"GET"})
     */
    public function userListe(UserRepository $userRepository): Response
    {
        return $this->render('admin/userliste.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

     /**
     * @Route("/admin/changeRole/{id}", name="admin_changeRole", methods={"GET"})
     */

     public function changeRole($id){

        $entityManager = $this->getDoctrine()->getManager();
        $user=new User();
        $repo= $this->getDoctrine()->getRepository(user::class);
        
        $user=$repo->find($id);

        $user-> setRoles(["ROLE_ADMIN"]);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('admin/userliste.html.twig',);

     }
}
