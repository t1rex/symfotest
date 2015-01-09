<?php

namespace Symfotest\TestBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CommentsAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('author')
            ->add('site')
            ->add('comment')
            ->add('rating')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('author')
            ->add('site')
            ->add('date')
            ->add('comment')
            ->add('rating')
            ->add('status', 'choice', array(
                'choices' => array(
                    'visible' => 'visible', 'invisible' => 'invisible'
                ),
                'required' => false))
            ->add('body', 'choice', array(
                'choices' => array(
                    '' => 'Do not send mail',
                    'Your comment posted' => 'Your comment posted',
                    'You denied posting comments: Your comment contain foul language' => 'You denied posting comments: Your comment contain foul language',
                    'You denied posting comments: not valid comment' => 'You denied posting comments: not valid comment',
                    'You denied posting comments: Your comment containing insults' => 'You denied posting comments: Your comment containing insults',
                    'Your comment has been changed' => 'Your comment has been changed',
                ),
                'required' => false))
            ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('author')
            ->add('site')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('author')
            ->add('date')
            ->add('site')
            ->add('comment')
            ->add('rating')
            ->add('status')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

}