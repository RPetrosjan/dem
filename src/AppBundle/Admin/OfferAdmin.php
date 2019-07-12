<?php


namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class OfferAdmin
 * @package AppBundle\Admin
 */
class OfferAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('typePro', TextType::class, [
                'label' => $this->trans('typePro'),
            ])
            ->add('code', TextType::class, [
                'label' => $this->trans('code'),
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->trans('description'),
            ])
            ->add('price', TextType::class, [
                'label' => $this->trans('price'),
            ])
            ;
    }


    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('typePro', TextType::class, [
                'label' => $this->trans('typePro'),
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('description', TextareaType::class, [
                'label' => $this->trans('description'),
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->addIdentifier('price', TextType::class, [
                'label' => $this->trans('price'),
                'route' => [
                    'name' => 'show',
                ]
            ])
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
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('typePro', TextType::class, [
                'label' => $this->trans('typePro'),
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->trans('description'),
            ])
            ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('typePro', null, [
                'label' => $this->trans('typePro'),
            ])
            ;
    }
}