<?php

namespace AppBundle\Form;

use AppBundle\Entity\CalculDevis;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
                 )
                )
            )
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
                    )
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

        ;


        /*

        $builder
            ->add('cp1',TextType::class,array(
            'label'=>'Code Postal'
             ))
            ->add('etage1','text',array(
                'attr' => array(
                    'class' => 'balloon etage'
                )
            ))
            ->add('ascenseur1','choice',array(
                'choices'  => array(
                    'Oui' => true,
                    'No' => false,
                ),
                'attr' => array(
                    'class' => 'balloon ascenseur'
                )
            ))
            ->add('cp2')
            ->add('etage2')
            ->add('ascenseur2')
            ->add('volume'); */
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
