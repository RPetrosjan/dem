<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/10/2018
 * Time: 13:42
 */

namespace AppBundle\Admin;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\DocPDF;
use AppBundle\Entity\Prestation;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class DemandeDevisAdmin extends AbstractAdmin
{

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id',
    ];

    // Creating new Custom route
    protected function configureRoutes(RouteCollection $collection) {

        $collection
            ->add('pdfdevis', $this->getRouterIdParameter().'/pdfdevis') // Action gets added automatically
            ->add('pdfcondgen', $this->getRouterIdParameter().'/pdfcondgen') // Action gets added automatically
            ->add('pdfdecval', $this->getRouterIdParameter().'/pdfdecval') // Action gets added automatically
            ->add('pdffacture', $this->getRouterIdParameter().'/pdffacture') // Action gets added automatically
            ->add('pdflettrechrg', $this->getRouterIdParameter().'/pdflettrechrg') // Action gets added automatically
            ->add('pdflettredechrg', $this->getRouterIdParameter().'/pdflettredechrg') // Action gets added automatically
            ->add('sendpdfdevis', $this->getRouterIdParameter().'/sendpdfdevis') //Action for generated and sending Devis

        ;

        ///$collection->clearExcept(['list', 'show', 'create', 'delete',  'edit']);

        //      $collection->add('view', $this->getRouterIdParameter().'/view');
    }

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    public function configureActionButtons($action, $object = null) {
        $list = parent::configureActionButtons($action,$object);
     /*   $list['custom_action'] = array(
            'template' =>  'admin/custom_button.html.twig',
        ); */
        return $list;
    }

    private $em;

    public function __construct($code, $class, $baseControllerName, $em) {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }


   // Filtering list result for calcul devis en ligne
   public function createQuery($context = 'list') {
      $query = parent::createQuery($context);
       $query->where(
           $query->getRootAliases()[0].'.nom IS not NULL'
       );
       return $query;
    }

    // Show Result in the Page
    protected function configureFormFields(FormMapper $formMapper) {


        $formMapper

            ->tab('Devis Déménagement')
            ->with('Info Date')
            ->add('CreatedDate', 'sonata_type_date_picker', [
                'label' => 'Date de demande',
                'format'=>'dd/MM/yyyy',
                'disabled' => true,
            ])

            ->add('Volume', TextType::class, [
                'label' => 'Volume',
                'required' => false,
            ])
            ->add('prestation', EntityType::class, [
                'class' => Prestation::class,
                'label' => 'Prestation'
            ])
            ->end()
            ->with('General', [
                    'class'       => 'col-md-4']
            )
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')

            ->end()
            ->with('Info Depart' ,[
                'class'       => 'col-md-4'
            ])
            ->add('date1')
            ->add('adresse1')
            ->add('cp1')
            ->add('etage1')
            ->add('ascenseur1',ChoiceType::class,[
                'empty_data'  => true,
                'choices'  => array(
                    'Oui' => 'Oui',
                    $this->trans('no') => 'No',
                ),
            ])
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-4'
            ])
            ->add('date2')
            ->add('adresse2')
            ->add('cp2')
            ->add('etage2')
            ->add('ascenseur2', ChoiceType::class,[
                'empty_data'  => true,
                'choices'  => array(
                    'Oui' => 'Oui',
                    $this->trans('no') => 'No',
                ),
            ])
            ->end()
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

        $repository = $em->getRepository(DocPDF::class);
     ///   $list_devis = $repository->findByDevisId($this->getRequest()->get('id'));
        $list_devis = $repository->findBy([
            'id_devis' => $this->getRequest()->get('id'),
        ] );
        $societe = $em->getRepository('AppBundle:Societe');
        $societe_devis_info = $societe->findOneBy(array('siege' => true));

        $showMapper
            ->tab($this->trans('Devis Info'))
            ->with('Info Date ')
            ->add('CreatedDate', null, [
                'label' => 'Date de demande',
                'format' => 'd/m/Y',
            ])
            ->add(
                'volume', null, [
                    'label' => 'Volume'
                ]
            )
            ->add('prestation', TextType::class, [
                'label' => 'Prestation',
            ])

            ->end()
            ->with('General', [
                    'class'       => 'col-md-4']
            )
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')

            ->end()
            ->with('Info Depart' ,[
                'class'       => 'col-md-4'
            ])
            ->add('date1')
            ->add('adresse1')
            ->add('cp1')
            ->add('etage1')
            ->add('ascenseur1')
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-4'
            ])
            ->add('date2')
            ->add('adresse2')
            ->add('cp2')
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
            ->add('prixform', 'string', [
                "template" => "admin/calculdevis/form.html.twig",
                'societe_devis_info' => $societe_devis_info,
            ])
            ->end()
            ->with('Tous les documents', [
                'class' => 'col-md-8'
            ])
            ->add('listedoc', null, [
                "template" => "admin/calculdevis/listdoc.html.twig",
                'list_devis' => $list_devis,
            ])
            ->end()

            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {

        unset($this->listModes['mosaic']);


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
                'format' => 'd/m/Y'
            ))
            ->addIdentifier('email ', null, [
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
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('date2', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('prestation', null, [
                'route' => [
                    'name' => 'show',
                ],
                'label' => 'Prestation',
            ])
            ->addIdentifier('volume', null, [
                'route' => [
                    'name' => 'show',
                ],
                'label' => 'Volume',
            ])
            // add custom action links
            ->add('_action', 'actions', array(
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
                    ))
            )
        ;
    }
}