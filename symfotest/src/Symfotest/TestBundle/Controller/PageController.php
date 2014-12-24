<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfotest\TestBundle\Entity\Comments;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('SymfotestTestBundle:Page:base.html.twig');
    }

    public function showAllAction()
    {
        $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();

        if (!$comments) {
            throw $this->createNotFoundException('No comments found');
        }
        return $this->render('SymfotestTestBundle:Page:table.html.twig', array('comments' => $comments));
    }

    public function showAuthorAction($author)
    {
        $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findBy(array('author' => $author));

        if (!$comments) {
            throw $this->createNotFoundException('No comments found for author ' . $author);
        }
        return $this->render('SymfotestTestBundle:Page:table_for_author.html.twig', array('comments' => $comments));
    }

    public function showSiteAction($site)
    {
        $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findBy(array('site' => $site));

        if (!$comments) {
            throw $this->createNotFoundException('No comments found for site ' . $site);
        }
        return $this->render('SymfotestTestBundle:Page:table_for_site.html.twig', array('comments' => $comments));
    }
}