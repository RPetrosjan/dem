<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 14.07.2018
 * Time: 00:38
 */

namespace AppBundle\Form;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\Prestation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add(
                $builder->create('Coordonnes', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label' => 'Coordonnées',
                    'label_attr' => array('class' => 'topformtoplabel devis'),
                ))
                    ->add('nom', TextType::class, array(
                        'label' => 'Votre nom',
                        'attr' => [
                            'autocomplete' => 'off',
                        ],

                    ))
                    ->add('prenom',TextType::class, array(
                        'label' => 'Votre prenom',
                        'attr' => [
                            'autocomplete' => 'off',
                        ],
                    ))
                    ->add('telephone',TextType::class, array(
                        'label' => 'Telephone',
                        'attr' => [
                            'autocomplete' => 'nope',
                        ],
                    ))
                    ->add('portable',TextType::class, array(
                        'label' => 'Portable',
                        'required' => false,
                        'attr' => [
                            'autocomplete' => 'off',
                        ],
                    ))
                    ->add('email',EmailType::class, array(
                        'label' => 'E-mail',
                        'attr' => [
                            'autocomplete' => 'nope',
                        ],
                    ))
            )
            ->add(
                $builder->create('Infodepart', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label' => 'Info départ',
                    'label_attr' => array('class' => 'topformtoplabel devis'),
                ))
                ->add('date1',TextType::class, array(
                    'label' => 'Date de demenagement',
                    'attr' => array(
                        'class' => 'datepicker',
                        'autocomplete' => 'off',
                    ),
                ))
                ->add('cp1', TextType::class, array(
                    'empty_data'  => '00000',
                    'label' => 'code postal ville',
                    'attr' => array(
                        'class' => 'cp_ville',
                        'autocomplete' => 'nope',
                    ),
                ))
                ->add('adresse1', TextType::class, array(
                    'empty_data'  => '',
                    'label' => 'adresse',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'nope',
                    ]
                ))
                ->add('pays1', TextType::class, array(
                    'empty_data'  => 'France',
                    'label' => 'Pays',
                    'data' => 'France',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'nope',
                    ]
                ))
                ->add('etage1', TextType::class, array(
                    'label' => 'Etage',
                    'empty_data'  => '0',
                    'attr' => [
                        'class' => 'etage',
                        'autocomplete' => 'off',
                    ],
                    'required' => false,
                ))
                ->add('ascenseur1', 'choice', array(
                    'empty_data'  => true,
                    'choices'  => array(
                        'Oui' => 'Oui',
                        'Non' => 'No',
                    ),
                    'attr' => [
                        'class' => 'ascenseur',
                        'autocomplete' => 'off',
                    ],
                    'label' => 'Ascenseur',
                    'required' => false,
                ))
                ->add('comment1', TextareaType::class, array(
                    'label' => 'Commentaire',
                    'required' => false,
                ))
            )
            ->add(
                $builder->create('Infoarrivee', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => array(
                        'class' => 'topformdiv',
                    ),
                    'label' => 'Info arrivée',
                    'label_attr' => array('class' => 'topformtoplabel devis'),
                ))
                ->add('date2',TextType::class, array(
                    'label' => 'Date de demenagement',
                    'attr' => [
                        'class' => 'datepicker',
                        'autocomplete' => 'off',
                    ],
                ))
                ->add('cp2', TextType::class, array(
                    'empty_data'  => '00000',
                    'label' => 'code postal ville',
                    'attr' => [
                        'class' => 'cp_ville',
                        'autocomplete' => 'nope',
                    ],
                ))
                ->add('adresse2', TextType::class, array(
                    'empty_data'  => '',
                    'label' => 'adresse',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ))
                ->add('pays2', TextType::class, array(
                    'empty_data'  => 'France',
                    'label' => 'Pays',
                    'data' => 'France',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ))
                ->add('etage2', TextType::class, array(
                    'label' => 'Etage',
                    'empty_data'  => '0',
                    'attr' => [
                        'class' => 'etage',
                        'autocomplete' => 'off',
                    ],
                    'required' => false,
                ))
                ->add('ascenseur2', 'choice', array(
                    'empty_data'  => true,
                    'choices'  => [
                        'Oui' => 'Oui',
                        'Non' => 'No',
                    ],
                    'attr' => [
                        'class' => 'ascenseur',
                        'autocomplete' => 'off',
                    ],
                    'label' => 'Ascenseur',
                    'required' => false,
                ))
                ->add('comment2', TextareaType::class, array(
                    'label' => 'Commentaire',
                    'required' => false,
                ))
            )

            ->add(
                $builder->create('InfoGeneral', FormType::class, array(
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'topformdiv',
                    ],
                    'label' => 'General',
                    'required' => false,
                    'label_attr' => array('class' => 'topformtoplabel devis general'),
                ))

                    ->add('prestation','choice',array(

                        'empty_data'  => 'Économique',

                        'choices' => array(

                            'Économique' => 'Économique',

                            'Standard' => 'Standard',

                            'Luxe' => 'Luxe',

                        ),

                        'attr' => [

                            'class' => 'prestation',

                            'readonly' => true,

                            'autocomplete' => 'off',

                        ],

                        'required' => false,





                    ))
                    /*
                ->add('prestation',EntityType::class, array(
                    'class' => Prestation::class,
                    'required' => false,
                    'attr' => [
                        'class' => 'prestation',
                        'readonly' => true,
                        'autocomplete' => 'off',
                    ],
                ))
                    */
                ->add('volume',TextType::class,array(
                    'empty_data'  => '0',
                    'label' => 'Volume',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ))
            )
            ->add('save', SubmitType::class, array(
                'label'=>'Valider',
            ))
            ;
    }

    /*
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DemandeDevis::class,
        ));
    }
}