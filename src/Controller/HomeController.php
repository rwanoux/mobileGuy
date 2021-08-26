<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(?UserInterface $user, ProductsRepository $repoProducts, SessionInterface $session): Response
    {
        if ($user) {
            $roles = $user->getRoles();
        } else {
            $username = "Non Connecté";
            $roles = ['ROLE_NA'];
        }

        $productsNew = $repoProducts->findNew();
        return $this->render('home/index.html.twig', [
            'products' => $productsNew,
            'roles' => $roles,
            'qttPanier' => $session->get('qttPanier')
        ]);
    }
}