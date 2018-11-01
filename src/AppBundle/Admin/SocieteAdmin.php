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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SocieteAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->tab($this->trans('Parametres Societe'))
            ->add('siege',CheckboxType::class,array(
                'label' => $this->trans('Sige Sociale')
            ))
            ->add('namesociete')
            ->add('siret', null, [
                'label' => 'N SIRET',
            ])
            ->add('adresse')
            ->add('cpville',ModelAutocompleteType::class,array(
                'property' => array(
                    'cp','ville'
                ),
            ))
            ->add('email')
            ->add('tel',CollectionType::class,array(
                'entry_type' => TelephoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('website', null, [
                'label' => 'Web Site',
                'required' => false,
            ])
            ->end()
            ->end()
            ->tab($this->trans('Parametres Devis'))
            ->add('prixtva', TextType::class, [
                'label' => 'TVA % Devis'
            ])
            ->add('accompte', TextType::class, [
                'label' => 'Accompte %'
            ])
            ->add('franchise', TextType::class, [
                'label' => 'Franchise €'
            ])
            ->add('valeurglobale', TextType::class, [
                'label' => 'Valeur globale €'
            ])
            ->add('parobjet', TextType::class, [
                'label' => 'Par objet non liste €'
            ])
            ->add('devisvalable', TextType::class, [
                'label' => 'Devis Valable'
            ])
            ->end()
            ->end()

        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('namesociete')
            ->add('cpville')
            ->add('email')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('siege')
            ->addIdentifier('namesociete')
            ->addIdentifier('cpville')
            ->addIdentifier('email')
        ;
    }
}