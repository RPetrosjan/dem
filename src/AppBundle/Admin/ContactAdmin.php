<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 24.08.2018
 * Time: 00:25
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class ContactAdmin extends AbstractAdmin
{

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    // Show Result in the Page
    protected function configureFormFields(FormMapper $formMapper){

       dump($this->getSubject()->getId());


        $formMapper
            ->add('CreatedDate', 'sonata_type_date_picker', [
                'label' => 'Date de demande',
                'format'=>'dd/MM/yyyy'
            ])
            ->add('name')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('portable')
            ->add('subject')
            ->add('commentaire')
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper){

    }
    public function configureShowFields(ShowMapper $showMapper){

    }

    protected function configureListFields(ListMapper $listMapper){
        $listMapper
            ->add('readed','boolean', [
                'template' => '/admin/boolean.html.twig',
                'editable' => true,
                'attr' => [
                    'boolean_values' => [
                        false => '<span class="label label-success">New</span>',
                        true => '<span class="label label-danger">Old</span>',
                    ]
                ],
            ])
            ->add('CreatedDate', null, array(
                'format' => 'd/m/Y H:i'
            ))
            ->addIdentifier('name')
            ->addIdentifier('prenom')
            ->addIdentifier('email')
            ->addIdentifier('subject')
        ;
    }

}