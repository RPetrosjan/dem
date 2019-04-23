<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/01/2019
 * Time: 01:30
 */

namespace AppBundle\Admin;


use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Form\EstimationPrixForm;
use AppBundle\service\ViewDevisCountService;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Traits\EstimationPrixSubmitForm as PrixSubmitform;

/**
 * Class DevisEnvoyeAdmin
 * @package AppBundle\Admin
 */
class DevisEnvoyeAdmin extends AbstractAdmin
{
    use PrixSubmitform;

    /** @var  */
    private $object;

    /** @var ContainerInterface|null  */
    private $container;

    /** @var EntityManager|object  */
    private $em;

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');

        $this->setTemplate('edit','admin/calculDevisEnvoyeAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param ViewDevisCountService $viewDevisCountService
     */
    public function __construct($code, $class, $baseControllerName, Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');

        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * We check if user is Owner of the devis?
     *
     * @param string $action
     * @param null $object
     */
    public function checkAccess($action, $object = null)
    {

        if(strcmp('list', $action) !=0 ) {

            /** @var int  $currentUSerId */
            $currentUSerId = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getId();
    
            /** @var int $devisOwnerId */
            $devisOwnerId = $object->getUserId()->getId();

            if(false === $this->isGranted('ROLE_ALL_DEVIS_ENVOYE_READER') && $currentUSerId != $devisOwnerId) {
                throw new AccessDeniedException(sprintf('Access Denied to the action'));
            }
        }
        parent::checkAccess($action, $object); // TODO: Change the autogenerated stub

    }


    // Filtering list result for calcul devis en ligne
    public function createQuery($context = 'list')
    {
        /** @var  $container */
        $container = $this->getConfigurationPool()->getContainer();
        /** @var  $userEntity */
        $userEntity = $container->get('security.token_storage')->getToken()->getUser();

        /** @var $query */
        $query = parent::createQuery($context);


        // Get submit Requet
        $inSearch = $this->getRequest()->get('search_in_table');
        if(is_null($inSearch)) {
            $inSearch = '';
        }

        $this->getConfigurationPool()->getContainer()->get('twig')->addGlobal('search_in_table', $inSearch);
        $filterMapped = ['devisnumber', 'prixht', 'nom', 'prenom', 'email', 'CreatedDate'];

        // Creation Query OR OR OR
        $searchQuery = '';
        // List de paramters
        $setParam = [];
        $alias = $query->getRootAliases()[0];
        foreach ($filterMapped as $key => $list) {
            $searchQuery.=$alias.'.'.$list.' like :'.$list;
            if($key < sizeof($filterMapped) - 1) {
                $searchQuery.=' OR ';
            }
            $setParam[$list] = '%'.$inSearch.'%';
        }


        if(!is_null($userEntity->getParent())) {
            $userEntity = $userEntity->getParent();
        }

        $query
            ->where($alias.'.user_id = :user_id')
            ->andWhere($searchQuery)
            ->setParameters(array_merge([
                'user_id' => $userEntity->getId(),
            ], $setParam));

        return $query;
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
        $this->object = $object;
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

            ->with($this->trans('info.devis'), [
                'class' => 'div-group-class col-md-12',
                'attr' => [
                    'icon' => '<i class="fas fa-info-circle"></i>',
                ]
            ])
            ->add('signee', CheckboxType::class, [
                'help' => 'Client accepteé ce devis',
                'required' => false,
                'attr' => [
                    'div-group-class' => 'div-group-class col-md-2 nopadding',
                ],
                'label' => $this->trans('devis.sign')
            ])
            ->add('helper', TextType::class, [
                'label' => 'helper',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-12',
                ]
            ])
            ->add('sous_traitance', CheckboxType::class, [
                'help' => $this->trans('souhaite.sous.traitance').'?',
                'required' => false,
                'attr' => [
                    'div-group-class' => 'col-md-2 nopadding',
                    //      'class' => 'ba-field-hidden',li
                ],
            ])

            ->add('prix_soustraitance', TextType::class, [
                'label' => 'Prix Sous-traitance',
                'required' => false,
                'attr' => [
                    ///      'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-2',
                ]
            ])
            ->end()
            ->with($this->trans('general'), [
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
            ->add('createdDataText', TextType::class, [
                'disabled' =>  true,
                'label' => 'Date de Demande',
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
            ->add('date2', TextType::class, [
            'attr' => [
                'class' => 'datepicker'
                ]
            ])
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
            ->add('devisnumber')
            ->add('nom')
            ->add('prenom')

        ;
    }


    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $contact = $this->getSubject();
        $contact->setReaded(true);
        $em->persist($contact);
        $em->flush();

        $userEntity = $container->get('security.token_storage')->getToken()->getUser();
        // We check if user have parent
        if(!is_null($userEntity->getParent())) {
            $userEntity = $userEntity->getParent();
        }

        $devisConfig = current($em
            ->getRepository(DevisConfig::class)
            ->findBy([
                'user_id' => $userEntity,
        ]));

        // Generate URL of admin devis
        /** @var string $url */
        $url = $container->get('router')->generate('admin_app_devisenvoye_show', [
            'id' => $this->object->getUuid()
        ]);
        $url = substr($url,0,-4);


        // Add show button for PDF Imprimer le Devis
        $this->getConfigurationPool()->getContainer()->get('twig')->addGlobal('pdf_button_name', [
            'label' => $this->trans('imprimer.devis'),
            'icon' => '<i class="fas fa-print"></i>'
        ]);

        $this->loadSubmitForm($userEntity);

        $showMapper
            ->tab($this->trans('Devis '.$this->object->getDevisNumber()), [
                'attr' => [
                    'icon' => '<i class="fas fa-mail-bulk"></i>'
                ]
            ])

            ->with('Estimation Prix', [
                'class'       => 'col-md-5',
                'attr' => [
                    'icon' => '<i class="fas fa-paper-plane"></i>',
                ]
            ])
            ->add('prixform', EstimationPrixForm::class, [
                "template" => $this->load_template,
                'label' => 'Prix',
                'attr' => [
                    'form' => $this->formEstimationPrix->createView(),
                ]
            ])
            ->end()
            ->with('Devis '.$this->object->getDevisNumber(), [
                'class' => 'col-md-7',
                'attr' => [
                    'icon' => '<i class="fas fa-mail-bulk"></i>',
                ]
            ])
            ->add('preview', null, [
                'template' => 'admin/demandedevis/previsualisation_devis.html.twig',
                'mapped' => false,
                'attr' => [
                    'url_devis' => $url,
                ]
            ])
            ->end()
            ->with('DEVIS PRÉVISUALISER', [
                'class' => 'col-md-7',
                'attr' => [
                    'icon' => '<i class="fas fa-file-archive"></i>',
                ]
            ])
            ->add('listdocs', null, [
                'template' => 'admin/demandedevis/previsualisation_devis.html.twig',
                'mapped' => false,
            ])

            ->end()

            ->end()
            ->tab($this->trans('Devis Info'), [
                'attr' => [
                    'icon' => '<i class="fas fa-paperclip"></i>',
                ]
            ])
            ->with($this->trans('info.devis'), [
                'class' => 'div-group-class col-md-12',
                'attr' => [
                    'icon' => '<i class="fas fa-info-circle"></i>',
                ]
            ])

            ->add('signee', null, [
                'help' => 'Client accepteé ce devis',
                'required' => false,
                'attr' => [
                    'div-group-class' => 'div-group-class col-md-2 nopadding',
                ],
                'label' => $this->trans('devis.sign')
            ])




            ->add('sous_traitance', null, [
                'label' => 'Sous Traitance'
            ])

            ->add('prix_soustraitance', TextType::class, [
                'label' => 'Prix Sous-traitance',
            ])


            ->end()

            ->with($this->trans('general'), [
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

            ->with('Info Déménagement ',[
                'class'       => 'col-md-6 title_devis',
                'attr' => [
                    'icon' => '<i class="fas fa-info"></i>',
                ]
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

            ->with('Info Depart' ,[
                'class'       => 'col-md-6',
                'attr' => [
                    'icon' => '<i class="fas fa-map-signs"></i>',
                ]
            ])
            ->add('date1')
            ->add('adresse1')
            ->add('cp1')
            ->add('ville1')
            ->add('etage1')
            ->add('ascenseur1')
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
            ->add('ascenseur2',ChoiceType::class,[
                'attr' => [
                    'class' => 'asc_selector2',
                ],
            ])
            ->end()
            ->end()

        ;
    }

    protected function configureListFields(ListMapper $listMapper) {

        unset($this->listModes['mosaic']);

        $listMapper
            ->addIdentifier('devisnumber', null, [
                'label' => 'Numero Devis',
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('signee', null, [
                'label' => 'Signeé',
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('prixht', null, [
                'label' => 'Prix HT ',
                'route' => [
                    'name' => 'show',
                ]
            ])

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
              ->addIdentifier('email ', null, [
                  'route' => [
                      'name' => 'show',
                  ]
              ])
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y',
                'label' => 'Devis Envoyée',
                'route' => [
                    'name' => 'show',
                ]
            ))

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