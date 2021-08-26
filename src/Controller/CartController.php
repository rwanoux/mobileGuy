<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductsRepository $repoProduct): Response
    {
        $panier = $session->get('panier', []);
        $panierFull = [];
        $totalPrix = 0;
        $totalQtt = 0;


        foreach ($panier as $id => $qtt) {
            $panierFull[] = [
                'product' => $repoProduct->find($id),
                'qtt' => $qtt
            ];
        }
        foreach ($panierFull as $line) {
            $totalItem = $line['qtt'] * $line['product']->getPrix();
            $totalPrix += $totalItem;
            $totalQtt += $line['qtt'];
        }

        $session->set('qttPanier', $totalQtt);
        // dd($panierFull);
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'mon panier',
            'content' => $panierFull,
            'totalPrix' => $totalPrix,
            'qttPanier' => $session->get('qttPanier')
        ]);
    }
    /**
     *@Route("/cart/remove/{id}", name="cart_remove")
     *
     * 
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function addProduct($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }
}