<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 16/09/2018
 * Time: 01:58
 */

namespace AppBundle\Form;


use AppBundle\Entity\CartonsForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

            $builder->add(
                $builder->create('Coordonnees', FormType::class, [
                    'inherit_data' => true,
                    'attr' => [
                        'class' => 'topformdiv',
                    ],
                    'label' => ' ',
                    'label_attr' => array('class' => 'topformtoplabel devis'),
                ])
                    ->add('name', TextType::class, [
                        'label' => 'Votre Nom',
                    ])
                    ->add('forname', TextType::class, [
                        'label' => 'Votre Prenom',
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Email',
                    ])
                    ->add('tel', TextType::class, [
                        'label' => 'Téléphone',
                    ])
                    ->add('portable', TextType::class, [
                        'label' => 'Portable',
                    ])
                    ->add('cartonJson', HiddenType::class, [
                        'attr' => [
                            'class' => 'hidedn'
                        ]
                ])
        )
                ->add('save', SubmitType::class, array(
                    'label'=>'Envoyer',
                ))
        ;

    }

    /*
 * {@inheritdoc}
  */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CartonsForm::class,
        ));
    }

}