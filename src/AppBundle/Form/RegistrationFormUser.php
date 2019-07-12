<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 13/12/2018
 * Time: 16:35
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormUser extends AbstractType
{


    /**
     * RegistrationFormUser constructor.
     */
    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('username',TextType::class, [
                'label' => 'Identifiant'
            ])
            ->add('email',TextType::class, [
                'label' => 'E-mail',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom Entreprise',
            ])
            ->add('siret', TextType::class, [
                'label' => 'Siret',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ])
;

            /*
            ->add('firstName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Prenom',
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom Entreprise',
            ])
            ->add('siret', TextType::class, [
                'label' => 'Siret',
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
            ])
            ->add('country', TextType::class, [
                'label' => 'Country'
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
            ])
            ->add('street', TextType::class, [
                'label' => 'Street',
            ])

            ;
            */
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}