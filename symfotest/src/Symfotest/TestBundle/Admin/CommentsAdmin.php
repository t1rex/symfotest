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
            ->add('status')
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
//            ->addIdentifier('status', null, array('route' => array('name' => 'edit')))
            ->add('status')
            ->add('_action', 'actions', array(
                'actions' => array(
//                    'confirm' => array('template' => 'SymfotestTestBundle:Page:confirm_button.html.twig'),
//                    'reject' => array('template' => 'SymfotestTestBundle:Page:reject_button.html.twig'),
                    'delete' => array(),
                    'edit' => array('status'),
                ),
                'edit' => 'inline'
            ))
        ;
    }

}