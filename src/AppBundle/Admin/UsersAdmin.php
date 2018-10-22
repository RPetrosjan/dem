<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Roles;
use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class UsersAdmin extends AbstractAdmin
{
    public function configureShowFields(ShowMapper $showMapper)
    {

    }

    public function prePersist($object) {
        parent::prePersist($object);
        $this->updateUser($object);
    }

    public function preUpdate($object) {
        parent::preUpdate($object);
        $this->updateUser($object);
    }

    public function updateUser(\AppBundle\Entity\User $u) {
        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $um->updateUser($u, false);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        global $kernel;

        $allroles = (current($kernel->getContainer()->get('security.role_hierarchy')));
        dump($allroles);
        $roleslist =[];
        foreach ($allroles as $key=>$values){
            $roleslist[$key]=$values[0];
        }

        $passwordoptions=array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.password'),
            'second_options' => array('label' => 'form.password_confirmation'),
            'translation_domain' => 'FOSUserBundle',
            'invalid_message' => 'fos_user.password.mismatch',
        );

        $this->record_id = $this->request->get($this->getIdParameter());
        if (!empty($this->record_id)) {
            $passwordoptions['required'] = false;
        } else {
            $passwordoptions['required'] = true;
        }

        $formMapper
            ->add('enabled','checkbox',array(
                'required' => false,
            ))
            ->add('username','text')
            ->add('email','text')
            ->add('age','text')
            ->add('plainPassword', 'repeated', $passwordoptions)
            ->add('roles',ChoiceType::class,array(
                'choices' => $roleslist,
                'multiple' => true,
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('age','text',array(
                'label' => $this->trans('Age'),
            ))
            ->addIdentifier('username','text',array(
                'label' => 'Nom',
            ))
            ->addIdentifier('email','text',array(
                'label' => 'Email',
            ))
            ->add('enabled','boolean',array(
                'label'=>$this->trans('Active'),
                'editable'=> true,
            ))
        ;
    }
}