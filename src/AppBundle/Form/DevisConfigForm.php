<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 25/01/2019
 * Time: 01:35
 */

namespace AppBundle\Form;


use AppBundle\Entity\DevisConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisConfigForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add(
                $builder->create('group1', FormType::class, [
                    'label' => 'Devis / Tarification',
                    'inherit_data' => true,
                    'attr' => [
                        'cutom_class' => 'col-md-6',
                        'icon' => '<i class="fas fa-exclamation-triangle"></i>'

                    ],
                ])
                    ->add('tva',TextType::class, [
                        'label' => 'TVA %',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
                    ->add('acompte',TextType::class, [
                        'label' => 'Acompte',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
                    ->add('franchise',TextType::class, [
                        'label' => 'Franchise €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
                    ->add('valglobale',TextType::class, [
                        'label' => 'Valeur globale €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
                    ->add('parobjet',TextType::class, [
                        'label' => 'Par objet non liste €',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
                    ->add('valable',TextType::class, [
                        'label' => 'Devis valable (mois)',
                        'attr' => [
                            'class' => 'form-control',
                            'divclass' => 'col-md-4'
                        ]
                    ])
            )


            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
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
            'data_class' => DevisConfig::class,
        ));
    }
}

