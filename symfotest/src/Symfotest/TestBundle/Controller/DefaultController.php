<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfotest\TestBundle\Entity\Comments;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SymfotestTestBundle:Default:index.html.twig', array('name' => $name));
    }

    public function tableAction($name)
    {
        return $this->render('SymfotestTestBundle:Table:index.html.twig', array('name' => $name));
    }

    public function createAction()
    {
        $currentData = new \DateTime("now");

        $comment = new Comments();
        $comment->setAuthor('Chuck');
        $comment->setDate($currentData);
        $comment->setSite('site.com.ua');
        $comment->setComment('some text of the comment');
        $comment->setRating(5);
        $comment->setStatus(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new Response('Created comment id' . $comment->getId());
    }
public function showAction($id)
    {
        $comment = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('No comments found for id' . $id);
        }
        var_dump($comment);
        return $this->render('SymfotestTestBundle:Table:table_for_id.html.twig', array('comment' => $comment));
    }
}
