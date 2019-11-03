<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-11-02
 * Time: 18:11
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
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
           return new Response("Future page to show the article " . $slug ." " . $slug2 );
       }

}
