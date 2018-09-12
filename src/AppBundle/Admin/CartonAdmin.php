<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 10.09.2018
 * Time: 22:28
 */

namespace AppBundle\Admin;

use AppBundle\Form\Type\ImageType;
use Doctrine\DBAL\Types\TextType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CartonAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){
        
        $formMapper
            ->add('code_carton')
            ->add('image_carton',CollectionType::class,array(
                'label' => $this->trans('Image'),
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('nom')
            ->add('dimension')
            ->add('price')
            ->add('description')

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper){

    }
    public function configureShowFields(ShowMapper $showMapper){

        $imgobj = $this->getSubject()->getImageCarton()->getValues()[0];
        dump($imgobj->getPath());
        dump($imgobj->getFilename());


        $showMapper

            ->add('image_carton', ImageType::class, [
                'template' => 'admin/ImageShowPrivew.html.twig'
                ]
            )
            ->add('nom')
            ->add('dimension')
            ->add('price')
            ->add('description')
        ;
    }

    protected function configureListFields(ListMapper $listMapper){
        $listMapper
            ->addIdentifier('image_carton', null, [
                'template' => 'admin/ListMapperImage.html.twig',
                'label' => 'Image'
            ])
            ->addIdentifier('nom')
            ->addIdentifier('dimension')
            ->addIdentifier('price','text', [
                'editale' => true,
                'template' => 'admin/AddPrixEuro.html.twig',
            ])
            ;
    }

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('/admin/image_edit.html.twig')
        );
    }
}