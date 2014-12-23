<?php
namespace AppBundle\Controller;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    /**
     * @Route("/hello/{firstName}/{lastName}", name="hello")
     */
    public function indexAction($firstName, $lastName)
    {
        return new Response('<html><body>Hello '. $firstName .'!</body></html>');
//        return $this->redirect($this->generateUrl('homepage'));
    }

}