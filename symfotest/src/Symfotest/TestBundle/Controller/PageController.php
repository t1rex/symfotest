<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $newComment = new Comments();
        $newComment->setDate(new \DateTime("now"));
        $newComment->setSite('https://getcomposer.org/download/');
        $newComment->setComment('testComment');
        $newComment->setRating(1);
        $newComment->setStatus(5);
        $form = $this->createFormBuilder($newComment)
            ->add('author', 'text', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('site', 'url', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('comment', 'textarea', array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('rating', 'choice', array(
                'choices'   => array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                    ),
                'required'  => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', 'submit', array('label' => 'Create comment'))
            ->getForm();

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            $newComment->prepareURL();
            if($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();
                $newComment = null;

                $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();
                if (!$comments) {
                    throw $this->createNotFoundException('No comments found');
                }

                $response = $this->renderView('SymfotestTestBundle:Page:table.html.twig', array('comments' => $comments));

                return new JsonResponse($response);
            }
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