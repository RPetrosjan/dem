<?php


namespace AppBundle\Form;


use AppBundle\Entity\RIB;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class RibForm extends AbstractType
{

    /** @var TranslatorInterface  */
    private $translator;

    /**
     * DevisConfigForm constructor.
     * @param TranslatorInterface $translator
     * @param TokenStorage $token
     * @param EntityManagerInterface $em
     */
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('group1', FormType::class, [
                    'label' => $this->translator->trans('rib.societe'),
                    'inherit_data' => true,
                    'attr' => [
                        'cutom_class' => 'col-md-8',
                        'icon' => '<i class="fas fa-money-check-alt"></i>'

                    ],
                ])
                ->add('nomTitulaire', TextType::class, [
                    'label' => $this->translator->trans('nomTitulaire'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-6'
                    ],
                ])
                ->add('prenomTitulaire', TextType::class, [
                    'label' => $this->translator->trans('prenomTitulaire'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-6'
                    ],
                ])
                ->add('hidden', HiddenType::class, [
                    'mapped' => false,
                ])
                ->add('banque', TextType::class, [
                    'label' => $this->translator->trans('banque'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-2'
                    ],
                ])
                ->add('guichet', TextType::class, [
                    'label' => $this->translator->trans('guichet'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-2'
                    ],
                ])
                ->add('ndeCompte', TextType::class, [
                    'label' => $this->translator->trans('ndeCompte'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-3'
                    ],
                ])
                ->add('cleRib', TextType::class, [
                    'label' => $this->translator->trans('cleRib'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-1'
                    ],
                ])

                ->add('domiciliation', TextType::class, [
                    'label' => $this->translator->trans('domiciliation'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-4'
                    ],
                ])

                ->add('bIC', TextType::class, [
                    'label' => $this->translator->trans('bIC'),
                    'attr' => [
                        'class' => 'form-control',
                        'divclass' => 'col-md-6'
                    ],
                ])
                    ->add('nIbanInternational', TextType::class, [
                        'label' => $this->translator->trans('nIbanInternational'),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-6'
                        ],
                    ])

                    ->add('save', SubmitType::class, [
                        'label' => 'Enregistrer',
                        'attr' => [
                            'class' => 'btn btn-success'
                        ]
                    ])
            )



        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RIB::class,
        ));
    }
}