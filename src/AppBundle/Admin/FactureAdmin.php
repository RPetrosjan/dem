<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/04/2019
 * Time: 11:59
 */

namespace AppBundle\Admin;
use Doctrine\DBAL\Types\TextType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class FactureAdmin
 * @package AppBundle\Admin
 */
class FactureAdmin extends AbstractAdmin
{
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
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
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
        $filterMapped = ['modePayement', 'montantPayement', 'numeroFacture'];

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


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('numeroFacture')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper) {

        $this->getConfigurationPool()->getContainer()->get('twig')->addGlobal('pdf_button_name', [
            'label' => $this->trans('imprimer.facture'),
            'icon' => '<i class="fas fa-print"></i>'
        ]);

        $showMapper
            ->tab($this->trans('Facture '.$this->object->getNumeroFacture()), [
                'attr' => [
                    'icon' => '<i class="fas fa-file-invoice-dollar"></i>',
                ],
            ])

            ->with($this->trans('facture'), [
                    'class'       => 'col-md-6',
                    'attr' => [
                        'icon' => '<i class="fas fa-clipboard-list"></i>',
                    ],
                ]
            )

            ->add('numeroFacture', TextType::class, [
                'label' => $this->trans('numeroFacture'),
            ])
            ->add('montantPayementeuro', TextType::class, [
                'label' => $this->trans('montantPayement'),
            ])
            ->add('modePayement', TextType::class, [
                'label' => $this->trans('modePayement')
            ])
            ->end()
            ->end()
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {

        unset($this->listModes['mosaic']);

        $listMapper
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y',
                'label' => 'Date creé',
                'route' => [
                    'name' => 'show',
                ]
            ))
            ->addIdentifier('numeroFacture', null, [
                'label' => $this->trans('numeroFacture')
            ])
            ->addIdentifier('montantPayement', null,  [
                'label' => $this->trans('montantPayement')
            ])
            ->addIdentifier('modePayement', null, [
                'label' => $this->trans('modePayement')
            ])
        ;
    }
}