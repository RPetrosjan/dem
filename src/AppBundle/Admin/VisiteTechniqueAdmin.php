<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 05.09.2018
 * Time: 01:27
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class VisiteTechniqueAdmin extends AbstractAdmin
{
    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    private $em;

    public function __construct($code, $class, $baseControllerName, $em) {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        //Modification valeur readed
        //Appell service orm service.yml
        $contact = $this->getSubject();
        $contact->setReaded(true);
        $this->em->persist($contact);
        $this->em->flush();

        $formMapper
            ->with('Info Date')
            ->add('CreatedDate', 'sonata_type_date_picker', [
                'label' => 'Date de demande',
                'format'=>'dd/MM/yyyy'
            ])
            ->end()
            ->with('General', [
                'class' => 'col-md-6',
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('portable')
            ->end()
            ->with('Info départ', [
                'class' => 'col-md-6',
            ])
            ->add('datesouhaite')
            ->add('adresse')
            ->add('cpville')
            ->add('ville')
            ->add('commentaire')
            ->end()
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper){
        $datagridMapper
            ->add('readed')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('datesouhaite')
            ->add('telephone')
            ->add('portable')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper){

        // Modification valeur readed
        // Appell service orm service.yml
        $contact = $this->getSubject();
        $contact->setReaded(true);
        $this->em->persist($contact);
        $this->em->flush();

        $showMapper
            ->with('Info Date')
            ->add('CreatedDate', 'date', [
                'format'=>'d/m/Y',
                'label' => 'Date Demande'
            ])
            ->end()
            ->with('Coordonnées', [
                'class' => 'col-md-6',
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('portable')
            ->end()
            ->with('Info Visite', [
                'class' => 'col-md-6',
            ])
            ->add('datesouhaite')
            ->add('adresse')
            ->add('cpville')
            ->add('ville')
            ->add('commentaire')
            ->end()
        ;
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
            ->addIdentifier('nom', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('prenom', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('email', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('datesouhaite', null , [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            )
        ;
    }


}