<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfotest\TestBundle\Entity\Comments;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('SymfotestTestBundle:Page:base.html.twig');
    }

    public function showAllAction(Request $request)
    {
        $currentData = new \DateTime("now");

        $newComment = new Comments();
        $newComment->setAuthor('form');
        $newComment->setDate($currentData);
        $newComment->setSite('form');
        $newComment->setComment('form');
        $newComment->setRating(5);
        $newComment->setStatus(1);

        $form = $this->createFormBuilder($newComment)
            ->add('author', 'text')
            ->add('site', 'text')
            ->add('comment', 'text')
            ->add('rating', 'text')
            ->add('save', 'submit', array('label' => 'Create comment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('show_all'));
        }

        $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();

        if (!$comments) {
            throw $this->createNotFoundException('No comments found');
        }
        return $this->render('SymfotestTestBundle:Page:table.html.twig', array('comments' => $comments, 'form' => $form->createView()));
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