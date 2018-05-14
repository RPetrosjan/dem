<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 11.05.2018
 * Time: 02:56
 */

namespace AppBundle\Admin;


use AppBundle\Form\Type\TelephoneType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SocieteAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('siege',CheckboxType::class,array(
                'label' => $this->trans('Sige Sociale')
            ))
            ->add('namesociete')
            ->add('adresse')
            ->add('cpville',ModelAutocompleteType::class,array(
                'property' => array(
                    'cp','ville'
                ),
            ))
            ->add('tel',CollectionType::class,array(
                'entry_type' => TelephoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('namesociete')
            ->add('cpville')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('siege')
            ->addIdentifier('namesociete')
            ->addIdentifier('cpville')
        ;
    }
}