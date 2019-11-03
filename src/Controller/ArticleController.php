<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-11-02
 * Time: 18:11
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
       public function homepage(){
           return new Response("Ohm My new page");
       }

    /**
 * @Route ("/news/{slug}/{slug2}")
 * @param $slug
 * @param $slug2
 * @return Response
 */
    public function show($slug, $slug2){
        return $this->render("article/show.html.twig",["title"=>"My first blog"]);
//           return new Response("Future page to show the article " . $slug ." " . $slug2 );
    }

    /**
     * @Route ("/news/{slug}")
     * @param $slug
     * @return Response
     */
    public function news($slug){
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];
        return $this->render("article/show.html.twig",["title"=>"My first blog", "slug"=>$slug, "comments"=>$comments]);
//           return new Response("Future page to show the article " . $slug ." " . $slug2 );
    }

}
