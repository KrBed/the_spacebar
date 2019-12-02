<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-11-02
 * Time: 18:11
 */

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * Currently unused: just showing a controller with a constructor!
     */
    private $isDebug;


    public function __construct($isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {


        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render("article/homepage.html.twig", ['ariticles' => $articles]);

    }

    /**
     * @Route ("/news/{slug}", name="article_show")
     * @param $slug
     * @param MarkdownParserInterface $markdown
     * @param AdapterInterface $cache
     * @return Response
     */
    public function show(Article $article, MarkdownHelper $markdownHelper, SlackClient $slack)
    {

        if ($article->getSlug() == 'khaaaaaan') {
            $slack->SendMessage('Khan', 'Ah,Kirk, my old friend...');
        }
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render("article/show.html.twig", ['article' => $article, "comments" => $comments]);
    }

    /**
     * @param $slug
     * @Route("/news/{slug}/heart",name="article_toogle_heart",methods={"POST"})
     * @return JsonResponse
     */
    public function toogleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();
        $logger->info("article is being hearted");

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }

}
