<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 16/09/2018
 * Time: 23:36
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Carton;
use AppBundle\Entity\CartonsForm;
use Doctrine\ORM\Mapping\Entity;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;

class CartonFormAdmin extends AbstractAdmin
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
        // Get doctrine Manager
        $this->em = $em;
    }

    // Show Result in the Page
    protected function configureFormFields(FormMapper $formMapper) {

        // Modification valeur readed
        // Appell service orm service.yml
        $contact = $this->getSubject();
        $contact->setReaded(true);
        $this->em->persist($contact);
        $this->em->flush();


        $formMapper
            ->with('Info Date')
            ->add('CreatedDate', 'sonata_type_date_picker', [
                'label' => 'Date de demande',
                'format'=>'dd/MM/yyyy',
                'disabled' => true
            ])
            ->end()
            ->with('Info Generale', [
                'class' => 'col-md-6',
            ])
            ->add('name')
            ->add('forname')
            ->add('email')
            ->add('tel')
            ->add('portable')
            ->end()
            ->with('Panier', [
                'class' => 'col-md-6',
            ])
            ->add('cartonJson', HiddenType::class, [
                'attr' => [
                    'class' => 'panel_show_form'
                ]
            ])
            ->add('carton', EntityType::class, [
                'class' => Carton::class,
                'multiple' => true,
            ])

            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper){
        $datagridMapper
            ->add('readed')
            ->add('name')
            ->add('forname')
            ->add('email')
            ->add('tel')
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
            ->tab('Demande de Carton Devis')
            ->with('Info Date')
            ->add('CreatedDate', 'date', [
                'format'=>'d/m/Y',
                'label' => 'Date Demande'
            ])
            ->end()
            ->with('Info Generale', [
                'class' => 'col-md-6',
            ])
            ->add('name')
            ->add('forname')
            ->add('email')
            ->add('tel')
            ->add('portable')
            ->end()
            ->with('Panier', [
                'class' => 'col-md-6',
            ])
            /*->add('cartonJson', TextType::class, [
                'label' => 'Demande de Cartons',
                'template' => 'admin/cartonJson.html.twig',

            ])*/
            ->add('carton', EntityType::class, [
                'label' =>  false,
                'route' => [
                    'name' => 'show',
                ],
                'template' => 'admin/cartonJson.html.twig',

            ])
            ->end()
            ->end()
            ->tab('Envoyer Reponse')
            ->with('Coordones')

            ->add('form', null, [
                'template' => "admin/cartonEnvoyerForm.html.twig",
            ])

            ->end()
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
            ->addIdentifier('name', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('forname', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('email', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('portable', null, [
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

    // Get possibility make Carton Persit form Carton and Cartonform
    public function preValidate($object)
    {
        /*
        // Get Carton(s) by code_carton
        $cartonsPersist = $this->em->getRepository(Carton::class)
            ->findBy(['code_carton' => ['DDKLF','ALSPD','DLFKF']])
       ;
        // Make in Class Array
        $object->setCarton($cartonsPersist);
        */
        parent::preValidate($object); // TODO: Change the autogenerated stub
    }

}