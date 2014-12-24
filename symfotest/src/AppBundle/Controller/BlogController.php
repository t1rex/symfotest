<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @Route("/blog/{page}", defaults={"page" = 1})
     */
    public function indexAction($page)
    {
        echo $page;
        return new Response('blog action test');
    }
    /**
     * @Route("/blog/{slug}")
     */
    public function showAction($slug)
    {
        return new Response('This is ' . $slug);
    }
}