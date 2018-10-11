<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 27.06.2018
 * Time: 02:29
 */

namespace AppBundle\Admin;


use AppBundle\Service\GetFormClass;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CalculDevisAdmin extends AbstractAdmin
{

    // Creating Sort By DateTime ASC
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'CreatedDate',
    ];

    protected function configureRoutes(RouteCollection $collection){

        $collection->add('pdfdevis', $this->getRouterIdParameter().'/pdfdevis'); // Action gets added automatically
        dump($collection);
  //      $collection->add('view', $this->getRouterIdParameter().'/view');
    }

    public function configure(){

       /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/calculDevisAdminEdit.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action,$object);
        $list['custom_action'] = array(
            'template' =>  'admin/custom_button.html.twig',
        );
        return $list;
    }

    // Filtering list result for calcul devis en ligne
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where(
            $query->getRootAliases()[0].'.date IS NOT NULL'
        );
        return $query;
    }

    // Show Result in the Page
        protected function configureFormFields(FormMapper $formMapper){


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
            ->add('cp1')
            ->add('etage1')
            ->add('ascenseur1',ChoiceType::class,[
                'empty_data'  => true,
                'choices'  => array(
                    'Oui' => 'Oui',
                    'No1' => 'No',
                    'NSDo2' => 'No',
                    'NSDDSo3' => 'No',
                    'SD' => 'No',
                    'DS' => 'No',
                    'SFD74D' => 'No',
                    'NSDo7' => 'No',
                    'SD ' => 'No',
                    'S22D' => 'No',
                    'SADDS45' => 'No',
                    'SSAD' => 'No',
                    'NS7Do7' => 'No',
                    'SD875' => 'No',

                ),
            ])
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-4'
            ])
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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('CreatedDate')
            ->add('nom')
            ->add('prenom')
            ->add('cp1')
            ->add('cp2')
            ->add('date')
        ;
    }

    public function preUpdate($user)
    {
        dump($user);
    }


    public function configureShowFields(ShowMapper $showMapper){


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
            ->add('cp1')
            ->add('etage1')
            ->add('ascenseur1')
            ->end()
            ->with('Info Arrivee' ,[
                'class'       => 'col-md-4'
            ])
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
                ])
            ->end()

            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
                ))
            )
        ;
    }
}