<?php

namespace Symfotest\TestBundle\EventListener;

class AdminApplicationListener
{
    /**
     *
     * @var Swift_Mailer
     */
    private $__mailer = null;
    private $__templating = null;

    public function __construct(\Swift_Mailer $mailer, $templating)
    {
        $this->__mailer = $mailer;
        $this->__templating = $templating;
    }

    public function onApplication( \Sonata\AdminBundle\Event\PersistenceEvent $event )
    {
        $ac = $event->getObject();

        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject('[VendorName] Object was edited')
            ->setFrom('admin@VendorName.ru')
            ->setTo($ac->getEmail())
            ->setBody(
                $this->__templating->render(
                    'SymfotestTestBundle:Page:email.html.twig',
                    array('name' => $ac->getAuthor())
                )
            )
        ;
        $this->__mailer->send($message);

    }
}