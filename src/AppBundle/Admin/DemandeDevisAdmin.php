<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/10/2018
 * Time: 13:42
 */

namespace AppBundle\Admin;


use AppBundle\Entity\DocPDF;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class DemandeDevisAdmin extends AbstractAdmin
{

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'CreatedDate',
    ];

    protected function configureRoutes(RouteCollection $collection) {

        $collection
            ->add('pdfdevis', $this->getRouterIdParameter().'/pdfdevis') // Action gets added automatically
            ->add('sendpdfdevis', $this->getRouterIdParameter().'/sendpdfdevis') //Action for generated and sending Devis
        ;
        //      $collection->add('view', $this->getRouterIdParameter().'/view');
    }

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    public function configureActionButtons($action, $object = null) {
        $list = parent::configureActionButtons($action,$object);
        $list['custom_action'] = array(
            'template' =>  'admin/custom_button.html.twig',
        );
        return $list;
    }

    private $em;

    public function __construct($code, $class, $baseControllerName, $em) {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }

    /*
   // Filtering list result for calcul devis en ligne
   public function createQuery($context = 'list') {
      $query = parent::createQuery($context);
       $query->where(
           $query->getRootAliases()[0].'.date IS NULL'
       );
       return $query;
    }*/

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
                'format'=>'dd/MM/yyyy'
            ])
            ->add('date', TextType::class, [
                'label' => 'Date de demenagement',
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
                    'No' => 'No',
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

    public function preUpdate($user) {
        dump($user);
    }


    public function configureShowFields(ShowMapper $showMapper) {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $contact = $this->getSubject();
        $contact->setReaded(true);
        $em->persist($contact);
        $em->flush();


        $repository = $em->getRepository(DocPDF::class);
        $list_devis = $repository->findByDevisId($this->getRequest()->get('id'));



        $showMapper

            ->tab($this->trans('Devis Info'))
            ->with('Info Date ')
            ->add('CreatedDate', null, [
                'label' => 'Date de demande',
                'format' => 'd/m/Y',
            ])
            ->add('date', TextType::class, [
                'label' => 'Date de demenagement',
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
            ->addIdentifier('date', null, [
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
            // add custom action links
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ))
            )
        ;
    }
}