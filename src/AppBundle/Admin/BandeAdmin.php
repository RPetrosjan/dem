<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 30.04.2018
 * Time: 07:27
 */

namespace AppBundle\Admin;


use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BandeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){

        $formMapper
            ->add('title')
            ->add('icon')
            ->add('description')
            ->add('url')
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('icon')
        ;
        }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('title')
            ->add('icon')
            ;
    }
}