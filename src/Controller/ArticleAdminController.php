<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleAdminController extends AbstractController
{
    /**
     * @Route("admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            $em->persist($article);
            $em->flush();

            $this->addFlash("success", 'Article created');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', ['articleForm' => $form->createView()]);
    }

    /**
     * @Route(path="/admin/article/{id}/edit",name="admin_article_edit")
     * @IsGranted("MANAGE",subject="article")
     */
    public function edit(Article $article,EntityManagerInterface $em,Request $request)
    {
       $form = $this->createForm(ArticleFormType::class,$article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            $this->addFlash("success", 'Article updated! Innacurancies Squashed');

            return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId()]);
        }

        return $this->render('article_admin/edit.html.twig', ['articleForm' => $form->createView()]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/article_admin/article" , name="admin_article_list")
     * @param ArticleRepository $articleRepo
     */
    public function list(ArticleRepository $articleRepo)
    {
        $articles = $articleRepo->findAll();

        return $this->render('article_admin/list.html.twig',['articles'=>$articles]);
    }
}