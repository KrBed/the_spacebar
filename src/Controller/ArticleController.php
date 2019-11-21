<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-11-02
 * Time: 18:11
 */

namespace App\Controller;


use App\Service\MarkdownHelper;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Nexy\Slack\Client;
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
    public function homepage()
    {
        return $this->render("article/homepage.html.twig", array());
//        return new Response("Ohm My new page");
    }

//    /**
//     * @Route ("/news/{slug}/{slug2}")
//     * @param $slug
//     * @param $slug2
//     * @return Response
//     */
//    public function show($slug, $slug2)
//    {
//        return $this->render("article/show.html.twig", ["title" => "My first blog"]);
////           return new Response("Future page to show the article " . $slug ." " . $slug2 );
//    }

    /**
     * @Route ("/news/{slug}", name="article_show")
     * @param $slug
     * @param MarkdownParserInterface $markdown
     * @param AdapterInterface $cache
     * @return Response
     */
    public function show($slug, MarkdownHelper $markdownHelper, Client $slack)
    {

        if ($slug == 'khaaaaaan') {
            $message = $slack->createMessage()
                ->from('Khan')
                ->withIcon(':ghost')
                ->setText('Ah,Kirk, my old friend...');
            dump($message);
            die;
            $slack->sendMessage($message);
        }
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;

//        $item = $cache->getItem('markdown_'.md5($articleContent));
//
//        if (!$item->isHit()) {
//            $item->set($markdown->transformMarkdown($articleContent));
//            $cache->save($item);
//        }
//        $articleContent = $item->get();
//        dump($cache);die;
        $articleContent = $markdownHelper->parse($articleContent);

        return $this->render("article/show.html.twig", ["title" => "My first blog", "slug" => str_replace("-", " ", ucwords($slug, "-")),
            "comments" => $comments, "articleContent" => $articleContent]);

    }

    /**
     * @param $slug
     * @Route("/news/{slug}/heart",name="article_toogle_heart",methods={"POST"})
     * @return JsonResponse
     */
    public function toogleArticleHeart($slug, LoggerInterface $logger, ContainerInterface $container)
    {

        $heart = rand(5, 100);
        $logger->info("article is being hearted");


        return new JsonResponse(['hearts' => $heart]);
    }

}
