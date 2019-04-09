<?php


namespace AppBundle\Admin;


use AppBundle\Entity\MesDevis;
use AppBundle\Form\EstimationPrixForm;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class SousTraitanceAdmin extends MesDevisAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('pdfdevis', $this->getRouterIdParameter().'/pdfdevis');
    }

    // We wel recreate getObject in par Defaut it will be show with id getObject find
    public function getObject($id)
    {

        $object = $this->getModelManager()->findOneBy(MesDevis::class, [
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
     * @return ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var $query */
        $query = parent::createQuery($context);

        // Creation Query OR OR OR
        $searchQuery = '';
        // List de paramters
        $setParam = [];

        $alias = $query->getRootAliases()[0];
        $query
            ->where($alias.'.sous_traitance = :sous_traitance')
            ->setParameters(array_merge([
                'sous_traitance' => true,
            ], $setParam));

        return $query;
    }

    public function configure() {
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {

    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $formEstimationPrix = $container->get('form.factory')->create(EstimationPrixForm::class, null, [
            'action' => $container->get('router')->generate('sonata_sendDevis_post', [
                'uuid' => $this->object->getUuid(),
            ]),
        ])->createView();

        $showMapper

            ->with($this->trans('company.info'), [
                'class' => 'col-md-12',
                'attr' => [
                    'icon' => '<i class="fas fa-info"></i>',
                ],
            ])
                ->add('user_id.companyName', null, [
                    'label' => $this->trans('company')
                ])
                ->add('nom_prenom', null, [
                     'label' => $this->trans('Nom Prenom')
                ])
                ->add('user_id.tel', null, [
                    'label' => $this->trans('telefon')
                ])
                ->add('user_id.mobile', null, [
                    'label' => $this->trans('mobile')
                ])
                ->add('user_id.email', null, [
                    'label' => $this->trans('email')
                ])
            ->end()
            ->with($this->trans('info.devis'), [
                    'class' => 'col-md-12',
                    'attr' => [
                        'icon' => '<i class="fas fa-map-signs"></i>'
                    ]
                ])
                ->add('prix_soustraitance', null, [
                    'label' => $this->trans('prix')
                ])
                ->add('date1', null, [
                    'label' => $this->trans('date1')
                ])
                ->add('cp_ville1', null, [
                    'label' => $this->trans('cp1')
                ])
                ->add('cp_ville2', null, [
                    'label' => $this->trans('cp2')
                ])
                ->add('prestation', null, [
                    'label' => $this->trans('prestation')
                ])
                ->add('volume', null, [
                    'label' => $this->trans('volume')
                ])
            ->end()
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('user_id.companyName', null, [
                'label' => $this->trans('company'),
                'route' => [
                    'name' => 'show',
                ]
             ///   'template' => 'admin/action/sous_traitance_action.html.twig',
            ])
            ->addIdentifier('date1', null, [
                'label' => $this->trans('date1'),
                'route' => [
                    'name' => 'show',
                ]
              //  'template' => 'admin/action/sous_traitance_action.html.twig',
            ])
            ->addIdentifier('cp1', null, [
                'label' => $this->trans('cp1'),
                'route' => [
                    'name' => 'show',
                ]
               // 'template' => 'admin/action/sous_traitance_action.html.twig',
            ])
            ->addIdentifier('cp2', null, [
                'label' => $this->trans('cp2'),
                'route' => [
                    'name' => 'show',
                ]
               /// 'template' => 'admin/action/sous_traitance_action.html.twig',
            ])
            ->addIdentifier('prix_soustraitance', null, [
                'label' => $this->trans('Prix'),
                'route' => [
                    'name' => 'show',
                ]
             ///  'template' => 'admin/action/sous_traitance_action.html.twig',
            ])
            ;
    }


}