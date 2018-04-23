<?php

namespace AppBundle\Form;

use AppBundle\Entity\CalculDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculDevisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            $builder->create('Depart', FormType::class, array(
                'inherit_data' => true,
                 'attr' => array(
                     'class' => 'topformdiv',
                 ),
                 'label' => 'Départ',
               ))
                ->add('cp1', TextType::class, array(
                    'empty_data'  => '00000',
                    'label' => 'code postal ville',
                    'attr' => array(
                        'class' => 'cp_ville',
                    )
                ))
                ->add('etage1', TextType::class, array(
                    'label' => 'Etage',
                    'empty_data'  => '0',
                    'attr' => array(
                        'class' => 'etage'
                    ),
                ))
                ->add('ascenseur1', 'choice', array(
                    'empty_data'  => true,
                    'choices'  => array(
                        'Oui' => true,
                        'No' => false,
                    ),
                    'attr' => array(
                        'class' => 'ascenseur'
                    ),
                    'label' => 'Ascenseur'
                ))
            )
            ->add(
                $builder->create('Arrivee', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label'=>'Arrivée',
                ))
                    ->add('cp2', TextType::class, array(
                        'empty_data'  => '00000',
                        'label' => 'code postal ville',
                        'attr' => array(
                            'class' => 'cp_ville',
                        )
                    ))
                    ->add('etage2', TextType::class, array(
                        'label' => 'Etage',
                        'empty_data'  => '0',
                        'attr' => array(
                            'class' => 'etage'
                        ),
                    ))
                    ->add('ascenseur2', 'choice', array(
                        'empty_data'  => false,
                        'choices'  => array(
                            'Oui' => true,
                            'No' => false,
                        ),
                        'attr' => array(
                            'class' => 'ascenseur'
                        ),
                        'label' => 'Ascenseur'
                    ))
            )
            ->add(
                $builder->create('General', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label'=>'General',
                ))
                ->add('prestation','choice',array(
                    'empty_data'  => 'Économique',
                    'choices' => array(
                        'Économique' => 'Économique',
                        'Standard' => 'Standard',
                        'Luxe' => 'Luxe',
                    )

                ))
                ->add('volume',TextType::class,array(
                    'empty_data'  => '0',
                    'label' => 'Volume',
                ))
            )
            ->add('save', SubmitType::class, array(
                'label'=>'Calculer le prix',
            ))

        ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CalculDevis::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_calculdevis';
    }


}
