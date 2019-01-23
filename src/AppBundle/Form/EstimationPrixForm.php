<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 23/01/2019
 * Time: 01:44
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EstimationPrixForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add(
                $builder->create('group_top', FormType::class, [
                    'label' => ' sds',
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

                ])
                    ->add('prixht',TextType::class, [
                        'label' => 'Prix HT €',
                        'attr' => [
                            'class' => 'form-control',
                        ]
                    ])
                    ->add('tva',TextType::class, [
                        'label' => 'TVA %',
                        'attr' => [
                            'class' => 'form-control',
                        ]
                    ])
                    ->add('prixttc',TextType::class, [
                        'label' => 'Prix TTC €',
                        'disabled' => true,
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])

            )
            ->add(
                $builder->create('group', FormType::class, [
                    'label' => ' sds',
                    'attr' => [
                        'class' => 'col-md-12',

                    ],

                ])
                    ->add('acompte',TextType::class, [
                        'label' => 'Acompte %',
                        'attr' => [
                            'class' => 'form-control',
                        ]
                    ])
                    ->add('acomptecommande',TextType::class, [
                        'label' => 'Acompte commande €',
                        'attr' => [
                            'class' => 'form-control',
                        ]
                    ])
                    ->add('soldelivraison',TextType::class, [
                        'label' => 'Solde livraison €',
                        'disabled' => true,
                        'attr' => [
                            'class' => 'form-control'
                        ]
                    ])
            )


            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ])
        ;
    }
}