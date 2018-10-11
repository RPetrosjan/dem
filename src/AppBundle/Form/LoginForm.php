<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 23.08.2018
 * Time: 02:11
 */

namespace AppBundle\Form;


use AppBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add(
            $builder->create('Coordonnees', FormType::class, [
                'inherit_data' => true,
                'attr' => [
                    'class' => 'topformdiv',

                ],
                'label' => 'Connectiion',
                'label_attr' => array('class' => 'topformtoplabel devis'),
                ])
                    ->add('_username', TextType::class, [
                        'label' => 'Votre email',
                         'attr' => [
                             'autocomplete' => 'off',
                         ]
                    ])
                    ->add('_password',TextType::class, [
                        'label' => 'Mot de passe',
                        'attr' => [
                            'autocomplete' => 'off',
                        ]
                     ])
                    ->add('_csrf_token', HiddenType::class)

        )
            ->add('valider', SubmitType::class, array(
                'label'=>'Valider',
            ))
        ;
    }

}