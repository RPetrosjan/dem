<?php

namespace AppBundle\Form;

use AppBundle\Entity\CalculDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculDevisType extends AbstractType
{
    private $formstep = 2;
    /**
     * {@inheritdoc}
     */

    public function GetMaxStep(){
        return $this->formstep;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if(!isset($options['form_step']) ||  $options['form_step'] == 1)
        {
        $builder
            ->add(
            $builder->create('Depart', FormType::class, array(
                'inherit_data' => true,
                 'attr' => array(
                     'class' => 'topformdiv',
                 ),
                 'label' => 'Départ',
                'label_attr' => array('class' => 'topformtoplabel'),
               ))
                ->add('cp1', TextType::class, array(
                    'empty_data'  => '00000',
                    'label' => 'code postal ville',
                    'attr' => array(
                        'class' => 'cp_ville',
                    ),
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
                        'Oui' => 'Oui',
                        'No' => 'No',
                    ),
                    'attr' => array(
                        'class' => 'ascenseur'
                    ),
                    'label' => 'Ascenseur',
                ))
            )
            ->add(
                $builder->create('Arrivee', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label'=>'Arrivée',
                    'label_attr' => array('class' => 'topformtoplabel'),
                ))
                    ->add('cp2', TextType::class, array(
                        'empty_data'  => '00000',
                        'label' => 'code postal ville',
                        'attr' => array(
                            'class' => 'cp_ville',
                        ),
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
                            'Oui' => 'Oui',
                            'No' => 'No',
                        ),
                        'attr' => array(
                            'class' => 'ascenseur'
                        ),
                        'label' => 'Ascenseur',
                    ))
            )
            ->add(
                $builder->create('General', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label'=>'General',
                    'label_attr' => array('class' => 'topformtoplabel'),
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

    }
        else if($options['form_step'] == 2){
            $builder
                ->add(
                    $builder->create('Coordonnes', FormType::class, array(
                        'inherit_data' => true,
                        'attr' => array(
                            'class' => 'topformdiv',
                        ),
                        'label' => 'Coordonnes',
                        'label_attr' => array('class' => 'topformtoplabel coordonees'),
                    ))
                        ->add('nom', TextType::class, array(
                            'label' => 'Votre nom',
                        ))
                        ->add('prenom',TextType::class, array(
                            'label' => 'Votre prenom',
                        ))
                        ->add('date1',TextType::class, array(
                            'label' => 'Date de demenagement',
                            'attr' => array(
                                'class' => 'datepicker',
                            ),
                        ))
                        ->add('telephone',TextType::class, array(
                            'label' => 'Telephone',
                        ))
                        ->add('email',TextType::class, array(
                            'label' => 'E-mail',
                        ))
                        ->add('save', SubmitType::class, array(
                            'label'=>'Devis Gratuit',
                        ))
                );
        }

        $builder->add('form_step', HiddenType::class, array(
            'data' => isset($options['form_step']) ?  1 : $options['form_step'],
            'mapped' => false,
        ));
    }

    /*
    * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CalculDevis::class,
            'form_step' => 1,
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
