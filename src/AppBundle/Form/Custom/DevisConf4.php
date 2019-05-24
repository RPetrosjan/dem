<?php


namespace AppBundle\Form\Custom;

use AppBundle\Entity\AdValorem;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\PrestationCustom;
use AppBundle\Form\AdValoremForm;
use Ddeboer\Imap\Search\Text\Text;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;


class DevisConf4 extends AbstractType
{
    /** @var TranslatorInterface  */
    private $translator;

    /** @var object|string  */
    private $user;

    /** @var EntityManagerInterface  */
    private $em;

    /**
     * DevisConfigForm constructor.
     * @param TranslatorInterface $translator
     * @param TokenStorage $token
     * @param EntityManagerInterface $em
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $em, TokenStorageInterface $token) {

        $this->translator = $translator;
        $this->user = $token->getToken()->getUser();
        $this->em = $em;

    }

    /**
     * @param int $length
     * @param string $characters
     * @return string
     */
    public function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        /** @var  $charactersLength */
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $initiale = substr($options['data']->getNom(),0,1).substr($options['data']->getPrenom(),0,1);
         $builder
            ->add(
                $builder->create('group1', FormType::class, [
                    'label' => false,
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',
                    ],
                ])
                    ->add('devisnumber', TextType::class, [
                        'label' => $this->translator->trans('devis.n'),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-12'
                        ],
                        'data' => date('Ym').$this->generateRandomString(4),
                    ])
                    ->add('client',TextType::class, [
                        'label' => $this->translator->trans('client.n'),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-12',
                        ],
                        'data'=> $initiale.date('Ym'),
                    ])
            )

             ->add(
                 $builder->create('group10', FormType::class, [
                     'label' => false,
                     'inherit_data' => true,
                     'attr' => [
                         'class' => 'col-md-12',

                     ],

                 ])

                     ->add('userprestation', ChoiceType::class, [
                         'label' => $this->translator->trans('votre.prestation'),
                         'choices'  =>  $this->em->getRepository(PrestationCustom::class)->findUserPrestations($this->user),  // $this->em->getRepository(PrestationCustom::class)->findByCompetence(),
                         'attr' => [
                             'class' => 'form-control',
                             'divclass' => 'col-md-4'
                         ],
                     ])

             )

             ->add(
                 $builder->create('group12', FormType::class, [
                     'label' => false,
                     'inherit_data' => true,
                     'attr' => [
                         'class' => 'col-md-12',

                     ],

                 ])
                     ->add('id_advalorem', CollectionType::class, [
                         'entry_type' => AdValoremForm::class,
                         'allow_add' => true,
                         'allow_delete' => true,
                         'label' => $this->translator->trans('add.valorem'),
                     ])

                     ->add('advalorem', HiddenType::class, [
                         'mapped' => false,
                     ])
             )


            ->add(
                $builder->create('group2', FormType::class, [
                    'label' => false,
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

                ])

                    ->add('prixht',TextType::class, [
                        'label' => 'Prix HT €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('tva',TextType::class, [
                        'label' => 'TVA %',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('prixttc',TextType::class, [
                        'label' => 'Prix TTC €',
                        'disabled' => true,
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'mapped' => false,
                    ])


                    ->add('acompte',TextType::class, [
                        'label' => 'Acompte %',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('acomptecommande',TextType::class, [
                        'label' => 'Acompte commande €',
                        'disabled' => true,
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'mapped' => false,
                    ])
                    ->add('soldelivraison',TextType::class, [
                        'label' => 'Solde livraison €',
                        'disabled' => true,
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'mapped' => false,
                    ])
            )

            ->add(
                $builder->create('group3', FormType::class, [
                    'label' => false,
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

                ])
                    ->add('franchise',TextType::class, [
                        'label' => 'Franchise €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('valglobale',TextType::class, [
                        'label' => 'Valeur globale €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('parobjet',TextType::class, [
                        'label' => 'Par objet non liste €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
            )


            ->add(
                $builder->create('group4', FormType::class, [
                    'label' => false,
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

                ])
                    ->add('valable',TextType::class, [
                        'label' => 'Devis valable (mois)',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                    ])
                    ->add('distance',TextType::class, [
                        'label' => 'Distance',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false
                    ])

                    ->add('nature1',ChoiceType::class, [
                        'label' => $this->translator->trans('nature'),
                        'choices'  => [
                            'Organisé' => 'organise',
                            'Urbain'   => 'Urbain',
                            'Special'  => 'Special',
                        ],
                        'data' => $options['data']->getNature1() == null ? 'organise' : $options['data']->getNature1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])

            )

            ->add(
                $builder->create('group5', FormType::class, [
                    'label' => '<i class="fas fa-map-signs"></i> '.$this->translator->trans('depart'),
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],
                ])

                    ->add('passagefenetre1',ChoiceType::class, [
                        'label' => $this->translator->trans('passage.fenetre'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isPassagefenetre1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4',

                        ],

                    ])
                    ->add('digicode1',ChoiceType::class, [
                        'label' => $this->translator->trans('digicode'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isDigicode1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('portage1',ChoiceType::class, [
                        'label' => $this->translator->trans('portage'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isPortage1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('montemeubles1',ChoiceType::class, [
                        'label' => $this->translator->trans('montemeubles'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isMontemeubles1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('transbordement1',ChoiceType::class, [
                        'label' => $this->translator->trans('transbordement'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isTransbordement1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('stationement1',ChoiceType::class, [
                        'label' => $this->translator->trans('stationement'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isStationement1(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])

            )

            ->add(
                $builder->create('group6', FormType::class, [
                    'label' => '<i class="fas fa-map-signs"></i> '.$this->translator->trans('arrivee'),
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],
                ])

                    ->add('passagefenetre2',ChoiceType::class, [
                        'label' => $this->translator->trans('passage.fenetre'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isPassagefenetre2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4',

                        ],

                    ])
                    ->add('digicode2',ChoiceType::class, [
                        'label' => $this->translator->trans('digicode'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isDigicode2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('portage2',ChoiceType::class, [
                        'label' => $this->translator->trans('portage'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isPortage2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('montemeubles2',ChoiceType::class, [
                        'label' => $this->translator->trans('montemeubles'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isMontemeubles2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('transbordement2',ChoiceType::class, [
                        'label' => $this->translator->trans('transbordement'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isTransbordement2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
                    ->add('stationement2',ChoiceType::class, [
                        'label' => $this->translator->trans('stationement'),
                        'choices'  => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'data' => $options['data']->isStationement2(),
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ],
                        'required' => false,
                    ])
            )

             ->add(
                 $builder->create('group7', FormType::class, [
                     'label' => false,
                     'inherit_data' => true,
                     'attr' => [
                         'class' => 'col-md-12',

                     ],
                 ])
                     ->add('commentSociete', TextareaType::class, [
                         'label' => $this->translator->trans('comment')
                     ])


                ->add('save', SubmitType::class, [
                    'label' => 'Valider',
                    'attr' => [
                        'class' => 'btn btn-success'
                    ]
                ])
             )

             ->add('json', HiddenType::class, [
                 'attr' => [
                     'class' => 'hiddenjson'
                 ],
                 'mapped' => false,
             ])

        ;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DevisEnvoye::class,
        ));
    }
}

