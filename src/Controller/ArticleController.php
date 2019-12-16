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
use App\Repository\CommentRepository;
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
use Reflection;
use ReflectionObject;
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
     * @param ArticleRepository $repository
     * @param EntityManager $manager
     * @return Response
     */
    public function homepage(ArticleRepository $repository)
    {
            $articles = $repository->findAllPublishedOrderedByNewest();
            $array = [];
            return $this->render("article/homepage.html.twig", ['articles' => $articles]);
    }

    /**
     * @Route ("/news/{slug}", name="article_show")
     * @param $slug
     * @param MarkdownParserInterface $markdown
     * @param AdapterInterface $cache
     * @return Response
     */
    public function show(Article $article,  SlackClient $slack)
    {
        if ($article->getSlug() == 'khaaaaaan') {
            $slack->SendMessage('Khan', 'Ah,Kirk, my old friend...');
        }

        return $this->render("article/show.html.twig", ['article' => $article]);
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
