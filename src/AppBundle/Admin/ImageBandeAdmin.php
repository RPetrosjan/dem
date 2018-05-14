<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 12.05.2018
 * Time: 01:25
 */

namespace AppBundle\Admin;


use AppBundle\Entity\CpVille;
use AppBundle\Entity\Prestation;
use AppBundle\Form\Type\ImageType;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ImageBandeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){

        $formMapper
            ->tab($this->trans('Demenagement Ville'))
            ->with($this->trans('Inserez le ville depart ville Arrivee et le description'))
            ->add('villeArrivee',ModelAutocompleteType::class,array(
                'property' => array(
                    'cp','ville'
                ),
            ))
            ->add('villeDepart',ModelAutocompleteType::class,array(
                'property' => array(
                    'cp','ville'
                ),
            ))
            ->add('prix')
            ->add('prestation',EntityType::class, array(
                'class' => Prestation::class,
            ))
            ->add('description')
            ->end()
            ->end()
            ->tab($this->trans('Image'))
            ->with($this->trans('Inserez les photos du demenagement'))
            ->add('imagebande',CollectionType::class,array(
                'label' => $this->trans('Image'),
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->end()

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('villeDepart')
            ->add('villeArrivee')
        ;
    }

    public function getFormTheme()
    {
            return array_merge(

            array('/admin/image_edit.html.twig')
        );
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('villeDepart')
            ->addIdentifier('villeArrivee')
            ->addIdentifier('prestation')
            ->addIdentifier('prix')
        ;
    }
}