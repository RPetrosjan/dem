<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 16/02/2019
 * Time: 00:54
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class MaSocieteForm
 * @package AppBundle\Form
 */
class MaSocieteForm extends AbstractType
{
    /** @var AuthorizationCheckerInterface  */
    private $authorizationChecker;
    public function __construct(AuthorizationCheckerInterface  $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $image_path = null;
        if(isset($options['attr']['company_icon'])) {
            $image_path = $options['attr']['company_icon'];
        }

        $builder
        ->add(
            $builder->create('group1', FormType::class, [
                'label' => 'Info Société',
                'inherit_data' => true,
                'attr' => [
                    'cutom_class' => 'col-md-6',
                    'icon' => '<i class="fas fa-box-open"></i>'

                ],
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom Société',
                'disabled' => $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN') ? false:true,
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'

                ],
            ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET',
                'disabled' => $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN') ? false:true,
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'

                ]
            ])
            ->add('tel', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ]
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Portable',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ]
            ])

            ->add('companyEmail', TextType::class, [
                'label' => 'E-mail Société',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-12'
                ]
            ])

            ->add('website', TextType::class, [
                'label' => 'Site Web',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ],
                'required' => false,
            ])
            ->add('fax', TextType::class, [
                'label' => 'Fax',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ],
                'required' => false,
            ])
            ->add('street', TextType::class, [
                'label' => 'Adress',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-12'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ]
            ])
                ->add('city', TextType::class, [
                    'label' => 'Ville',
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-6'
                    ]
                ])
        )
        ->add(
            $builder->create('group2', FormType::class, [
                'label' => 'Info Gerant',
                'inherit_data' => true,
                'attr' => [
                    'cutom_class' => 'col-md-6',
                    'icon' => '<i class="fas fa-user-tie"></i>'

                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6'
                ]
            ])
                ->add('lastName', TextType::class, [
                    'label' => 'Nom',
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-6'
                    ]
                ])
        )

        ->add(
            $builder->create('group3', FormType::class, [
                'label' => 'Logo Societe',
                'inherit_data' => true,
                'attr' => [
                    'cutom_class' => 'col-md-6',
                    'icon' => '<i class="fas fa-image"></i>'

                ],
            ])
            ->add('file', FileType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'divclass' => 'col-md-6',
                    'image_path' => $image_path,
                ]
            ])
        )

        ->add('save', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ])
        ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event){
            $data = $event->getData();

            if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN') == false) {
                unset($data['group1']['companyName']);
                unset($data['group1']['siret']);
            }
        })
      ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}