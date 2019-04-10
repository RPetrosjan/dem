<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 23/12/2018
 * Time: 03:03
 */

namespace AppBundle\Admin;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\ReadyDemandeDevis;
use AppBundle\Form\EstimationPrixForm;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Class DemandeDevisAdmin
 * @package AppBundle\Admin
 */
class DemandeDevisAdmin extends AbstractAdmin
{

    /** @var object  */
    private $object;

    /** @var  */
    private $em;

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];


    /**
     *
     * SEARCH box
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var  $container */
        $container = $this->getConfigurationPool()->getContainer();

        /** @var $query */
        $query = parent::createQuery($context);


        // Get submit Requet
        $inSearch = $this->getRequest()->get('search_in_table');
        if(is_null($inSearch)) {
            $inSearch = '';
        }

        $this->getConfigurationPool()->getContainer()->get('twig')->addGlobal('search_in_table', $inSearch);
        $filterMapped = ['CreatedDate', 'cp1', 'cp2', 'date1', 'date2'];

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
          ///  ->where($alias.'.user_id = :user_id')
            ->andWhere($searchQuery)
            ->setParameters(array_merge([
////                'user_id' => $userEntity->getId(),
            ], $setParam));

        return $query;
    }

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName, $em)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }

    public function getDashboardActions()
    {

        $actions = parent::getDashboardActions();

        $allDemandeDevis = $this->em->getRepository(DemandeDevis::class)->getAllDemandeDevis();
        $container = $this->getConfigurationPool()->getContainer();
//        $userEntity = $container->get('security.token_storage')->getToken()->getUser();
//        $allDevisEnvoye  = $this->em->getRepository(DevisEnvoye::class)->getAllDevisEnvoye($userEntity->getId());

        $allDevisEnvoye = $container->get('admin.stat')->getStatDevisEnvoye();

        $actions['pageDashboard'][] = [
            'devis' => $allDemandeDevis,
            'statDevis' => $allDevisEnvoye,
            'template' => 'admin/statistique/devis.html.twig'
        ];

        return $actions;
    }


    public function configure() {
        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    public function delete($object)
    {
        $roles = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser()->getRoles();
        if(array_search('ROLE_SUPER_ADMIN', $roles) === false) {
            throw new AccessDeniedException('Access Denied to the action and role');
        }

        parent::delete($object); // TODO: Change the autogenerated stub
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

        $formMapper

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
            ->add('nom', null, [], EntityType::class, [
                'class' => DemandeDevis::class
            ])
            ->add('prenom')
            ->add('cp1')
            ->add('cp2')
            ->add('date1')
        ;
    }


    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $userEntity = $container->get('security.token_storage')->getToken()->getUser();
        $result = $em->getRepository(ReadyDemandeDevis::class)
            ->getReadedDemandeDevis($userEntity, $this->getSubject()->getUuid());

        if(empty($result) && $userEntity->getViewDevisCount()<1) {
            return $showMapper
                ->add('nothing', TextType::class, [
                    "template" => "admin/demandedevis/count_zero.html.twig",
                    'mapped' => false,
                ]);
        }

        // If not exist in the  ReadyDemandeDevis it will be add
        if(empty($result)) {
            $ready = new ReadyDemandeDevis();
            $ready->setIdUser($userEntity);
            $ready->setUuidDevis($this->getSubject()->getUuid());
            $em->persist($ready);
            $em->flush();

            $userEntity->setViewDevisCount($userEntity->getViewDevisCount()-1);
            $em->persist($userEntity);
            $em->flush();
        }


        $devisConfig = current($em
            ->getRepository(DevisConfig::class)
            ->findBy([
                'user_id' => $userEntity,
            ]));

        $sendDevis = new DevisEnvoye();
        $sendDevis->setTva($devisConfig == false ? 20: $devisConfig->getTva());
        $sendDevis->setAcompte($devisConfig == false ? 30 : $devisConfig->getAcompte());
        $sendDevis->setFranchise($devisConfig == false ? 250 : $devisConfig->getFranchise());
        $sendDevis->setValglobale($devisConfig == false ? 20000 : $devisConfig->getValglobale());
        $sendDevis->setParobjet($devisConfig == false ? 500 : $devisConfig->getParobjet());
        $sendDevis->setValable($devisConfig == false ? 3 : $devisConfig->getValable());


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
            ->add('readed','boolean', [
                'template' => '/admin/boolean.html.twig',
                'editable' => true,
                'data' => false,
                'attr' => [
                    'boolean_values' => [
                        false => '<span class="label label-success">Nouveau</span>',
                        true => '<span class="label label-danger">Vu</span>',
                    ]
                ],
            ])
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y',
                'label' => 'Demande',
                'route' => [
                    'name' => 'show',
                ]
            ))
          /*  ->addIdentifier('email ', null, [
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
            ])  */
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