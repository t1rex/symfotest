<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfotest\TestBundle\Entity\Comments;

class PageController extends Controller
{
    protected $statusMessage = '';
    public function indexAction()
    {
        return $this->render('SymfotestTestBundle:Page:base.html.twig');
    }

    public function showAllAction()
    {
        $newComment = new Comments();
        $newComment->setDate(new \DateTime("now"));
        $newComment->setComment('testComment');
        $newComment->setStatus(5);
        $form = $this->formCreator($newComment);

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

    private function formCreator($newComment){
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
                'attr' => array('class' => 'form-control col-lg-2')
            ))
            ->add('save', 'submit', array('label' => 'Create comment'))
            ->getForm();
        return $form;
    }

    /**
     * @param $session Session
     * @return bool
     */
    private function checkTime($session)
    {

        $timeOfCreated = $session->get('createComment');
        if ($timeOfCreated) {
            $timeMinutesAgo = new \DateTime('-1 minutes');
            return $timeMinutesAgo > $timeOfCreated ? true : false;
        }
        return true;
    }

    public function jsonHandlerAction(Request $request)
    {
        $session = $request->getSession();
        $newComment = new Comments();
        $newComment->setDate(new \DateTime("now"));
        $newComment->setStatus(1);
        $form = $this->formCreator($newComment);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            $newComment->prepareURL();

            $timeCheck = $this->checkTime($session);
            if (!$timeCheck) {
                return new JsonResponse(array('errorMessage' => 'You have already created message! Try again later!'));
            }

            $isValidate = true;
            $author = $form["author"]->getData();
            $comment = $form["comment"]->getData();
            if (strlen($author) < 6){
                $isValidate = false;
                $this->statusMessage .= 'The name of the author should be longer than 6 characters. ';
            }
            if (strlen($comment) < 10){
                $isValidate = false;
                $this->statusMessage .= 'Comment should contain more than 10 characters. ';
            }

            if($isValidate) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();

                $timeNow = new \DateTime('now');
                $session->set('createComment', $timeNow);

                $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();
                return new JsonResponse($this->renderView('SymfotestTestBundle:Page:only_table.html.twig', array('comments' => $comments)));
            } else {
                return new JsonResponse(array('errorMessage' => $this->statusMessage));
            }
        }
    }
}