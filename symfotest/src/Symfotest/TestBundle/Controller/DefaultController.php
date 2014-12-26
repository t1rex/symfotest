<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfotest\TestBundle\Entity\Comments;
use Symfotest\TestBundle\Entity\Task;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SymfotestTestBundle:Default:index.html.twig', array('name' => $name));
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
        return $this->render('SymfotestTestBundle:Table:table_for_id.html.twig', array('comment' => $comment));
    }

    public function formAction(Request $request = null)
    {
        // создаём задачу и присваиваем ей некоторые начальные данные для примера
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->getForm();

        return $this->render('SymfotestTestBundle:Page:table.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
