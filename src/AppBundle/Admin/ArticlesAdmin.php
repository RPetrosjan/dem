<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 05.05.2018
 * Time: 23:47
 */

namespace AppBundle\Admin;


use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticlesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper){

        $formMapper
            ->add('namePage')
            ->add('title')
            ->add('articleHtml',TextareaType::class,array(
                'label' => $this->trans('HTML Format')
            ))
            ->add('url')
            ->add('idArticle')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('namePage')
            ->add('title')
            ->add('idArticle')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('namePage')
            ->add('idArticle')
        ;
    }
}