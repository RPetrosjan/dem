<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 06/10/2018
 * Time: 14:14
 */

namespace AppBundle\Form;


use AppBundle\Entity\VisiteTechnique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteTechniqueForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add(
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
                ))
                ->add('prenom',TextType::class, array(
                    'label' => 'Votre prenom',
                ))
                ->add('telephone',TextType::class, array(
                    'label' => 'Telephone',
                ))
                ->add('portable',TextType::class, array(
                    'label' => 'Portable',
                    'required' => false,
                ))
                ->add('email',EmailType::class, array(
                    'label' => 'E-mail',
                ))
        )
        ->add(
            $builder->create('InfoVisiste', FormType::class, array(
                'inherit_data' => true,
                'attr' => array(
                    'class' => 'topformdiv',
                ),
                'label' => 'Info Visiste',
                'label_attr' => array('class' => 'topformtoplabel devis'),
            ))
                ->add('datesouhaite',TextType::class, array(
                    'label' => 'Date de demenagement',
                    'attr' => array(
                        'class' => 'datepicker',
                    ),
                ))
                ->add('cpville', TextType::class, array(
                    'empty_data'  => '00000',
                    'label' => 'code postal ville',
                    'attr' => array(
                        'class' => 'cp_ville',
                    ),
                ))
                ->add('adresse', TextType::class, array(
                    'empty_data'  => '',
                    'label' => 'adresse',
                    'required' => false,
                ))
                ->add('ville', TextType::class, array(
                    'empty_data'  => '',
                    'label' => 'adresse',
                    'required' => false,
                ))
                ->add('commentaire', TextareaType::class, array(
                    'label' => 'Commentaire',
                    'required' => false,
                ))


        )
        ->add('save', SubmitType::class, array(
            'label'=>'Valider',
        ))

        ;

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => VisiteTechnique::class,
        ));
    }
}