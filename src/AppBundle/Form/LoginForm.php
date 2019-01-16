<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 10/12/2018
 * Time: 01:25
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, [
            'label' => 'Indetifiant',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de Passe',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ])
        ;
    }
}