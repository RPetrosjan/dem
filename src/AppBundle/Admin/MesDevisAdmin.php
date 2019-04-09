<?php
namespace AppBundle\Admin;


use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\ReadyDemandeDevis;
use AppBundle\Form\EstimationPrixForm;
use AppBundle\service\ViewDevisCountService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
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

class MesDevisAdmin extends AbstractAdmin
{

    /** @var ViewDevisCountService  */
    private $viewDevisCountService;

    /** @var ContainerInterface|null  */
    private $container;

    /** @var EntityManager|object  */
    private $em;

    /** @var object|string  */
    private $user;

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param ViewDevisCountService $viewDevisCountService
     */
    public function __construct($code, $class, $baseControllerName, ViewDevisCountService $viewDevisCountService, Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');


        $this->viewDevisCountService = $viewDevisCountService;
        parent::__construct($code, $class, $baseControllerName);
    }


    /**
     * MesDevisAdmin constructor.
     * @param $object
     * @throws OptimisticLockException
     */
    public function preValidate($object) {

        $this->user = $this->container->get('security.token_storage')->getToken()->getUser();
        $object->setUserId($this->user);


        $objectToArray = (array)($object);
        $devis = [];
        foreach ($objectToArray as $key=>$value) {
            $devis[substr($key,27)] = $value;
        }

        // Check if user will share DEVIS
        if($object->isShare() == true) {
            // Add devis in DemandeDevis
            // Check if devis exist in DemandeDevis
            $result = $this->container->get('admin.add.in.demande.devis')->addDemandeDevisWithUser($devis);

            if($result == true) {
                // Add user 2 devis for show
                $this->viewDevisCountService->addDevisCount(2);

                $ready = new ReadyDemandeDevis();
                $ready->setIdUser($this->user);
                $ready->setUuidDevis($this->getSubject()->getUuid());
                $this->em->persist($ready);
                $this->em->flush();

            }
            else {
                $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()->add('error', $this->trans('devis.already.exist'));
            }

        }

        parent::preValidate($object); // TODO: Change the autogenerated stub
    }

    // Filtering list result for calcul devis en ligne

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
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
        $filterMapped = ['prenom', 'nom', 'cp1', 'cp2', 'date1', 'date2'];

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


        $query
            ->where($alias.'.user_id = :user_id')
            ->andWhere($searchQuery)
            ->setParameters(array_merge([
                'user_id' => $userEntity->getId(),
            ], $setParam));

        return $query;
    }

    public $object;

    // Creating Sort By DateTime ASC
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculMyDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    // TODO: ANKAP function remove in future
    /**
    public function delete($object)
    {
        $roles = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getRoles();
        if(array_search('ROLE_SUPER_ADMIN', $roles) === false) {
            throw new AccessDeniedException('Access Denied to the action and role');
        }

        parent::delete($object); // TODO: Change the autogenerated stub
    }
     */

    /**
     * We check if user is Owner of the devis?
     *
     * @param string $action
     * @param null $object
     */
    public function checkAccess($action, $object = null)
    {
        if(strcmp('list', $action) !=0 && strcmp('create', $action) !=0 ) {

            /** @var int  $currentUSerId */
            $currentUSerId = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getId();

            /** @var int $devisOwnerId */
            $devisOwnerId = $object->getUserId()->getId();

            if(false == $object->isSousTraitance() && (false === $this->isGranted('ROLE_ALL_DEVIS_ENVOYE_READER') && $currentUSerId != $devisOwnerId)) {
                throw new AccessDeniedException(sprintf('Access Denied to the action %s %s',__FILE__, __CLASS__));
            }
        }
        parent::checkAccess($action, $object); // TODO: Change the autogenerated stub
    }


    // We wel recreate getObject in par Defaut it will be show with id getObject find
    public function getObject($id)
    {
        $object = $this->getModelManager()->findOneBy($this->getClass(), [
            'uuid' => $id
        ]);
        $this->object = $object;
        return $object;
    }


    // We call new function for generating URL sonata
    public function getUrlsafeIdentifier($entity)
    {
        ///$this->getRoutes();
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

        // Her we will get all Roles for user
        /** @var  $roles
        $roles = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getRoles();
        if(array_search('ROLE_SUPER_ADMIN', $roles) === false) {
        if ($this->isCurrentRoute('edit')) {
        throw new AccessDeniedException('Access Denied to the action and role');
        }
        }
         * */

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $userEntity = $container->get('security.token_storage')->getToken()->getUser();

        $devisConfig = current($em
            ->getRepository(DevisConfig::class)
            ->findBy([
                'user_id' => $userEntity,
            ]));

        $formMapper

            ->with($this->trans('info.devis'), [
                'class' => 'div-group-class col-md-12',
                'attr' => [
                    'icon' => '<i class="fas fa-info-circle"></i>',
                ]
            ])
            ->add('share', CheckboxType::class, [
                'label' => $this->trans('partager'),
                'help' => $this->trans('partgae.info'),
                'required' => false,
                'disabled' => $this->object ? $this->object->isShare():false,
                'attr' => [
                    'div-group-class' => 'div-group-class col-md-12 nopadding',
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

            ->add('prix_ht', TextType::class, [
                'label' => 'Prix HT €',
                'required' => false,
                'attr' => [
                ///    'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-1',
                ]
            ])

            ->add('prix_tva', TextType::class, [
                'label' => 'TVA %',
                'required' => false,
                'data' => $devisConfig->getTva(),
                'attr' => [
             //       'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-1',
                ]
            ])

            ->add('prix_ttc', TextType::class, [
                'label' => 'Prix TTC',
                'required' => false,
                'attr' => [
             //       'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-1',
                ]
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

            ->add('civilite', ChoiceType::class, [
                'label' => $this->trans('civilite'),
                'mapped' => false,
                'choices'  => array(
                    'M ' => 'M',
                    'Mme ' => 'Mme',
                    'Mlle' => 'Mlle'
                ),
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->end()
            ->with('Info Déménagement', [
                'class'       => 'col-md-6 title_devis',
                'attr' => [
                    'icon' => '<i class="fas fa-info"></i>',
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('volume', TextType::class, [
                'label' => 'Volume',
                'attr' => [
                    'autocomplete' => 'nope',
                ]
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
                'required' => false,
                'attr' => [
                    'autocomplete' => 'nope',
                ]
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
                    'class' => 'datepicker',
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('adresse1', TextType::class,  [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('cp1', TextType::class,  [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('ville1', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('etage1', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
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
                    'class' => 'datepicker',
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('adresse2', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('cp2', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('ville2', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
            ->add('etage2', TextType::class, [
                'attr' => [
                    'autocomplete' => 'nope',
                ]
            ])
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
            ->add('date1')
        ;
    }


    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $contact = $this->getSubject();
        $em->persist($contact);
        $em->flush();


        $userEntity = $container->get('security.token_storage')->getToken()->getUser();

        $devisConfig = current($em
            ->getRepository(DevisConfig::class)
            ->findBy([
                'user_id' => $userEntity,
            ]));

        $sendDevis = new DevisEnvoye();
        $sendDevis->setTva($devisConfig->getTva());
        $sendDevis->setAcompte($devisConfig->getAcompte());
        $sendDevis->setFranchise($devisConfig->getFranchise());
        $sendDevis->setValglobale($devisConfig->getValglobale());
        $sendDevis->setParobjet($devisConfig->getParobjet());
        $sendDevis->setValable($devisConfig->getValable());


        $formEstimationPrix = $container->get('form.factory')->create(EstimationPrixForm::class, $sendDevis, [
            'action' => $container->get('router')->generate('sonata_sendDevis_post', [
                'uuid' => $this->object->getUuid(),
            ]),
        ])->createView();


        $showMapper
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
            ->add('share',null, [
                'label' => $this->trans('partager'),
                'attr' => [
                    'class' => 'col-md-6'
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

            ->add('prix_ht', TextType::class, [
                'label' => 'Prix HT €',
                'class' => 'red',
                'attr' => [
                    'div-group-class' => 'col-md-1',
                ]
            ])

            ->add('prix_tva', TextType::class, [
                'label' => 'TVA %',
                'required' => false,
                'data' => $devisConfig->getTva(),
                'attr' => [
                    //       'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-1',
                ]
            ])

            ->add('prix_ttc', TextType::class, [
                'label' => 'Prix TTC',
                'required' => false,
                'attr' => [
                    //       'class' => 'ba-field-hidden',
                    'div-group-class' => 'col-md-1',
                ]
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
            ->tab($this->trans('Faire un devis'), [
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
                "template" => "admin/demandedevis/estimation_prix.html.twig",
                'label' => 'Prix',
                'attr' => [
                    'form' => $formEstimationPrix,
                ]
            ])
            ->end()
            ->with('Devis prévisualiser', [
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
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {

        $roles = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getRoles();
        if(array_search('ROLE_SUPER_ADMIN', $roles) === false)
        {
            unset($this->listModes['list']);
        }
        // Remove list mode in top panel
        unset($this->listModes['mosaic']);

        $listMapper
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y',
                'label' => 'Date creé',
                'route' => [
                    'name' => 'show',
                ]
            ))
              ->addIdentifier('share ', 'boolean', [
                  'label' => 'Partage',
                  'route' => [
                      'name' => 'show',
                  ]
              ])


            ->addIdentifier('signee ', 'boolean', [
                'label' => 'Signee',
                'route' => [
                    'name' => 'show',
                ]
            ])

            ->addIdentifier('sous_traitance ', 'boolean', [
                'label' => 'Sous Traitance',
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
        ;


        /// dump($this->isGranted('ROLE_SUPER_ADMIN'));

        //       if($this->isGranted('ROLE_SUPER_ADMIN'))
        ///   if(array_search('ROLE_SUPER_ADMIN', $roles) !== false)
        {
            $listMapper
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
                );
        }

    }
}