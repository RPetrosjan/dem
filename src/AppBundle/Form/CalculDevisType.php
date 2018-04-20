<?php

namespace AppBundle\Form;

use AppBundle\Entity\CalculDevis;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

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
                    'label' => 'code postal ville',
                ))
                ->add('etage1', TextType::class, array(
                    'label' => 'Etage',
                    'attr' => array(
                        'class' => 'etage'
                    ),
                ))
                ->add('ascenseur1', 'choice', array(
                    'choices'  => array(
                        '' => null,
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
                        'label' => 'code postal ville',
                    ))
                    ->add('etage2', TextType::class, array(
                        'label' => 'Etage',
                        'attr' => array(
                            'class' => 'etage'
                        ),
                    ))
                    ->add('ascenseur2', 'choice', array(
                        'choices'  => array(
                            '' => null,
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
                    'choices' => array(
                        '' =>null,
                        'Économique' => 'Économique',
                        'Standard' => 'Standard',
                        'Luxe' => 'Luxe',
                    )

                ))
                ->add('volume',TextType::class,array(
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
