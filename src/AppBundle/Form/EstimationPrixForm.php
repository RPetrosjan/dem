<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 23/01/2019
 * Time: 01:44
 */

namespace AppBundle\Form;


use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\SendDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimationPrixForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('group1', FormType::class, [
                    'label' => ' sds',
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',
                    ],
                ])
                    ->add('devisnumber', TextType::class, [
                        'label' => 'Devis Numero',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-12'
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

            )
            ->add(
                $builder->create('group2', FormType::class, [
                    'label' => ' sds',
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

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
                    'label' => ' sds',
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
                    'label' => ' sds',
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
            )

            ->add('json', HiddenType::class, [
                'attr' => [
                    'class' => 'hiddenjson'
                ],
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
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