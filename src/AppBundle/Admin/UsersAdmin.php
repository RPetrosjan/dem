<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Roles;

use AppBundle\service\ImageResize;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;


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
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => false];
        if ($image && ($webPath = $image->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview"/>';
        }



        $allroles = (current($kernel->getContainer()->get('security.role_hierarchy')));
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
            ->with($this->trans('general'), [
                    'class'       => 'col-md-6',
                    'attr' => [
                        'icon' => '<i class="fas fa-clipboard-list"></i>',
                    ],
                ]
            )
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
            ->add('viewDevisCount', 'text')
            ->end()
            ->with('Company Info', [
                'class'       => 'col-md-6',
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom Société'
            ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET'
            ])
            ->add('street', TextType::class, [
                'label' => 'Adress'
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('tel', TextType::class, [
                'label' => 'Téléphone'
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Portable'
            ])
            ->add('companyEmail', TextType::class, [
                'label' => 'E-mail Société'
            ])
            ->add('Website', TextType::class, [
                'label' => 'Site Web'
            ])
            ->add('fax', TextType::class, [
                'label' => 'Fax'
            ])
            ->end()
            ->with('Company Icon', [
                'class'       => 'col-md-6',
            ])
            ->add('file', 'file', $fileFieldOptions)
            ->end()
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
            ->add('switch_to_user',TextType::class,[
                'label'=>$this->trans('Switch'),
                'template' => 'admin/switch/swhitch_to_user.html.twig'
            ])
        ;
    }
}