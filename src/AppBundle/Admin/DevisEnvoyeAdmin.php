<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/01/2019
 * Time: 01:30
 */

namespace AppBundle\Admin;


use AppBundle\Entity\DevisEnvoye;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class DevisEnvoyeAdmin
 * @package AppBundle\Admin
 */
class DevisEnvoyeAdmin extends AbstractAdmin
{
    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    public function getDashboardActions()
    {
        $actions = parent::getDashboardActions();
    }

    // We wel recreate getObject in par Defaut it serach with id getObject find
    public function getObject($id)
    {
        /** @var  $object DevisEnvoye */
        $object = $this->getModelManager()->findOneBy($this->getClass(), [
            'uuid' => $id
        ]);
        return $object;
    }

    // We call new function for generating URL sonata
    public function getUrlsafeIdentifier($entity)
    {
        return $this->getNormalizedIdentifier($entity);
    }

    // Here url make new paramters tu URL uuid
    public function getNormalizedIdentifier($entity)
    {
        // If id not exist it wille be create
        if(is_null($entity->getId()))
        {
            return parent::getNormalizedIdentifier($entity);
        }
        // If id exist wie show url with UUID paramter
        else{
            return $entity->getUuid();
        }
    }


    // Show Result in the Page
    protected function configureFormFields(FormMapper $formMapper) {


        $formMapper

            ->with('General', [
                    'class'       => 'col-md-6',
                    'attr' => [
                        'icon' => '<i class="fas fa-clipboard-list"></i>',
                    ],
                ]
            )
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')

            ->end()
            ->with('Info Date', [
                'class'       => 'col-md-6 title_devis',
                'attr' => [
                    'icon' => '<i class="fas fa-info"></i>',
                ]
            ])
            ->add('CreatedDate', 'sonata_type_date_picker', [
                'label' => 'Date de demande',
                'format'=>'dd/MM/yyyy',
                'required' => false,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('volume', TextType::class, [
                'label' => 'Volume',
            ])
            ->add('prestation', ChoiceType::class, [
                'label' => 'Prestation',
                'choices'  => array(
                    'Economique' => 'Economique',
                    'Standard' => 'Standard',
                    'Luxe' => 'Luxe'
                ),
            ])
            ->add('budget', TextType::class, [
                'label' => 'Budget prevu',
                'disabled' => true,
                'mapped' => false,
            ])
            ->end()

            ->with('Info Depart' ,[
                'class'       => 'col-md-6',
                'attr' => [
                    'icon' => '<i class="fas fa-map-signs"></i>',
                ]
            ])
            ->add('date1', TextType::class, [
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('adresse1')
            ->add('cp1')
            ->add('ville1')
            ->add('etage1')
            ->add('ascenseur1',ChoiceType::class,[
                'empty_data'  => true,
                'choices'  => array(
                    'Oui' => 'Oui',
                    'No' => 'No',
                ),
            ])
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-6',
                'attr' => [
                    'icon' => '<i class="fas fa-map-signs"></i>',
                ]
            ])
            ->add('date2')
            ->add('adresse2')
            ->add('cp2')
            ->add('ville2')
            ->add('etage2')
            ->add('ascenseur2', ChoiceType::class,[
                'empty_data'  => true,
                'choices'  => array(
                    'Oui' => 'Oui',
                    'No' => 'No',
                ),
            ])
            ->end()

        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('CreatedDate')
            ->add('nom')
            ->add('prenom')
            ->add('cp1')
            ->add('cp2')
            ->add('date')
        ;
    }


    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $contact = $this->getSubject();
        $contact->setReaded(true);
        $em->persist($contact);
        $em->flush();


        //  $societe = $em->getRepository('AppBundle:Societe');
        // $societe_devis_info = $societe->findOneBy(array('siege' => true));

        $showMapper
            ->tab($this->trans('Devis Info'))
            ->with('Info Déménagement ',[
                'class'       => 'col-md-6 title_devis'
            ])
            ->add('CreatedDate', null, [
                'label' => 'Date de demande',
                'format' => 'd/m/Y',
            ])
            ->add('volume', null, [
                'label' => 'Volume',
            ])
            ->add('prestation', null, [
                'label' => 'Prestation'
            ])
            ->add('budget', TextType::class, [
                'label' => 'Budget',
                'mapped' => false,
            ])
            ->end()
            ->with('General', [
                    'class'       => 'col-md-6']
            )
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')

            ->end()
            ->with('Info Depart' ,[
                'class'       => 'col-md-6'
            ])
            ->add('date1')
            ->add('adresse1')
            ->add('cp1')
            ->add('ville1')
            ->add('etage1')
            ->add('ascenseur1')
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-6'
            ])
            ->add('date2')
            ->add('adresse2')
            ->add('cp2')
            ->add('ville2')
            ->add('etage2')
            ->add('ascenseur2',ChoiceType::class,[
                'attr' => [
                    'class' => 'asc_selector2',
                ],
            ])
            ->end()
            ->end()
            ->tab($this->trans('Envoyer Devis'))

            ->with('Estimation Prix', [
                'class'       => 'col-md-4'
            ])
            ->end()
            ->with('Tous les documents', [
                'class' => 'col-md-8'
            ])

            ->end()

            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {

        $listMapper
            ->add('Status','boolean', [
                'template' => '/admin/boolean.html.twig',
                'editable' => true,
                'attr' => [
                    'boolean_values' => [
                        false => '<span class="label label-success">Nouveau</span>',
                        true => '<span class="label label-danger">Vu</span>',
                    ]
                ],
            ])
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y',
                'label' => 'Demande'
            ))
            /*  ->addIdentifier('email ', null, [
                  'route' => [
                      'name' => 'show',
                  ]
              ])
            */
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
            ->addIdentifier('cp1', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('cp2', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('date1', null, [
                'label' => 'Départ',
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('date2', null, [
                'label' => 'Arrivée',
                'route' => [
                    'name' => 'show',
                ]
            ])
            // add custom action links
            ->add('_action', 'actions', [
                    'label'=> 'Action',
                    'actions' => array(
                        'show' => [
                            'template' => 'admin/action/show_action.html.twig'
                        ],
                        'edit' => [
                            'template' => 'admin/action/edit_action.html.twig'
                        ],
                        'delete' => [
                            'template' => 'admin/action/remove_action.html.twig'
                        ],
                    )]
            )
        ;
    }

}