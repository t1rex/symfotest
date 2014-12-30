<?php

namespace Symfotest\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SymfotestUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
