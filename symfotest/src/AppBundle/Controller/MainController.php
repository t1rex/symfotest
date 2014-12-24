<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller
{
    public function homepageAction()
    {
        return new Response('homepage test');
    }

    public function contactAction()
    {
        return new Response('contact action test');
    }

    public function processContactAction()
    {
        return new Response('processContactAction test');
    }
}