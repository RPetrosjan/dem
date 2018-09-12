<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 21.05.2018
 * Time: 00:41
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SocialAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){

        $formMapper
            ->add('socialName')
            ->add('socialIcon')
            ->add('socialUrl')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('socialName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('socialName')
            ->add('socialUrl')
        ;
    }
}