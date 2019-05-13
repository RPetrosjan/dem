<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 13/12/2018
 * Time: 16:35
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ])
            ;
    }
}