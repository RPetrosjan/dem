<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 27.06.2018
 * Time: 02:29
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CalculDevisAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){

        $formMapper
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')
            ->add('date')
            ->add('cp1')
            ->add('etage1')
            ->add('ascenseur1')
            ->add('cp2')
            ->add('etage2')
            ->add('ascenseur2')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('CreatedDate')
            ->add('nom')
            ->add('prenom')
            ->add('cp1')
            ->add('cp2')
            ->add('date')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('CreatedDate')
            ->addIdentifier('nom')
            ->addIdentifier('prenom')
            ->addIdentifier('cp1')
            ->addIdentifier('cp2')
            ->addIdentifier('date')
        ;
    }
}