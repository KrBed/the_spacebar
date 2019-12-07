<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        /**
         * @var Article
         */
        die('todo');

        return new Response(sprintf('Hay! New article id : %d , %s', $article->getId(), $article->getSlug()));
    }
}