<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 25/09/2018
 * Time: 07:49
 */

namespace AppBundle\Admin;


use AppBundle\Form\Type\TelephoneType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FranceSocieteAdmin extends AbstractAdmin
{
    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nomSociete')
            ->add('nomGerant')
            ->add('prenomGerant')
            ->add('adresseSociete')
            ->add('telephoneSociete',CollectionType::class,array(
                'entry_type' => TelephoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('cpVilleSociete',ModelAutocompleteType::class,array(
                'property' => array(
                    'cp','ville'
                ),
            ))
            ->add('prestationSociete')
            ->add('descriptionsociete', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('active')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nomsociete')
            ->add('nomGerant')
            ->add('prenomGerant')
            ->add('adresseSociete')
            ->add('telephoneSociete')
            ->add('active')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nomsociete')
            ->addIdentifier('adresseSociete')
            ->addIdentifier('telephoneSociete')
            ->addIdentifier('active')
        ;
    }
}