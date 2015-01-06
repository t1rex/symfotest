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
    public function indexAction()
    {
        return $this->render('SymfotestTestBundle:Page:base.html.twig');
    }



    public function showAllAction(Request $request)
    {
        $session = $request->getSession();
        $newComment = new Comments();
        $newComment->setDate(new \DateTime("now"));
        $newComment->setComment('testComment');
        $newComment->setStatus(5);
        $form = $this->formCreator($newComment);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            $newComment->prepareURL();

            $timeCheck = $this->checkTime($session);
            if (!$timeCheck) {
                $error = 'You have already created message! Try again later!';$comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();
                return new JsonResponse(array('error' => $error));
            }

            if($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();

                $timeNow = new \DateTime('now');
                $session->set('createComment', $timeNow);

                $comments = $this->getDoctrine()->getRepository('SymfotestTestBundle:Comments')->findAll();
                return new JsonResponse($this->renderView('SymfotestTestBundle:Page:table.html.twig', array('comments' => $comments)));
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
    function checkTime($session)
    {

        $timeOfCreated = $session->get('createComment');
        if ($timeOfCreated) {
            $timeMinutesAgo = new \DateTime('-1 minutes');
            return $timeMinutesAgo > $timeOfCreated ? true : false;
        }
        return true;
    }
}