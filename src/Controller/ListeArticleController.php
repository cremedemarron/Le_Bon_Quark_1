<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/liste/article")
 */
class ListeArticleController extends AbstractController
{
   
    /**
     * @Route("/", name="liste_article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('liste_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/mesarticles", name="liste_article_mesarticles", methods={"GET"})
     */
    public function mesarticles(ArticleRepository $mesarticles): Response
    {
        return $this->render('liste_article/mesarticles.html.twig', [
            'articles' => $mesarticles->findAll(),
            
        ]);
    }

    /**
     * @Route("/new", name="liste_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
     $psedoAuteur = $this->getUser();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $article->setAuteure($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('liste_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('liste_article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            // 'auteure'=> $psedoAuteur
        ]);
    }

    /**
     * @Route("/{id}", name="liste_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('liste_article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="liste_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        // check for "edit" access: calls all voters
        // $this->denyAccessUnlessGranted('edit', $article);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('liste_article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="liste_article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
