<?php

namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SymfotestTestBundle:Default:index.html.twig', array('name' => $name));
    }
}
