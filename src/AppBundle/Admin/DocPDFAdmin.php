<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 03/12/2018
 * Time: 01:47
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DocPDFAdmin extends AbstractAdmin
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
        $this->em = $em;
    }

    public function configure() {

        /// $this->setTemplate('list','@AppBundle/Admin/ContactList.html.twig');
        $this->setTemplate('edit','admin/docpdf.html.twig');
        $this->setTemplate('show','admin/calculDevisAdminShow.html.twig');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('CreatedDate')
            ->add('randomname')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('cp1')
            ->add('cp2')
        ;
    }


    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
            ->add('randomname', UrlType::class)

            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('price');
    }

    protected function configureListFields(ListMapper $listMapper) {

        $listMapper
            ->addIdentifier('CreatedDate', null, array(
                'format' => 'd/m/Y H:i'
            ))
            ->addIdentifier('randomname', null, [
                'label' => 'N Devis'
            ])
            ->addIdentifier('nom')
            ->addIdentifier('prenom')
            ->addIdentifier('email')
            ->addIdentifier('telephone')
            ->addIdentifier('price')
            ->addIdentifier('cp1')
            ->addIdentifier('cp2')

        ;
    }
}