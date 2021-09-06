<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Entity\Article;
class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData= [] ;

        $total =0;
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'article' => $articleRepository -> find($id),
                'quantity' =>$quantity

               
            
            ];
        }

        foreach($panierWithData as $item){

            $totalitem = $item['article']->getPrice() * $item['quantity'];
            $total +=  $totalitem;
        }
       

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items'=> $panierWithData,
            'total'=> $total,
        ]);
            }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */

    public function add($id, SessionInterface $session)
    {

        
        $panier = $session->get('panier', []);

        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id] += 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('liste_article_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/panier/delete/{id}", name="panier_delete")
     */
public function delete ($id, SessionInterface $session)
{
    $panier = $session -> get('panier', []);

    if(!empty($panier[$id])){
        unset($panier[$id]);
    }
    $session-> set('panier', $panier);

    return $this->redirectToRoute("panier");
}

 /**
     * @Route("/panier/buy/{id}", name="panier_buy")
     */

public function buy($id){

    $entityManager = $this->getDoctrine()->getManager();
    $repo=$this->getDoctrine()->getRepository(article::class);
    
    $article=$repo->find($id);
   $user=$this->getUser()->setGalacticCredit($this->getUser()->getGalacticCredit()-$article->getPrice());
   $entityManager->persist($user);
   
   $entityManager->flush();
   $u =$this->getUser()->getGalacticCredit();

//    setGalacticCredit($user) = $user->getGalacticCredit() - $total;


return $this->render('panier/trensaction.html.twig', [
    'affichage' => $u,
]
 );
}

}
