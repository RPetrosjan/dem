<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 23.08.2018
 * Time: 02:11
 */

namespace AppBundle\Form;


use AppBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add(
            $builder->create('Coordonnees', FormType::class, [
                'inherit_data' => true,
                'attr' => [
                    'class' => 'topformdiv',
                ],
                'label' => 'Coordonnées',
                'label_attr' => array('class' => 'topformtoplabel devis'),
                ])
                    ->add('name', TextType::class, [
                        'label' => 'Votre nom',
                    ])
                    ->add('prenom',TextType::class, [
                        'label' => 'Votre prenom',
                     ])
                    ->add('telephone',TextType::class, [
                        'label' => 'Telephone',
                    ])
                    ->add('portable',TextType::class, [
                        'label' => 'Portable',
                        'required' => false,
                    ])
                    ->add('email',EmailType::class, [
                        'label' => 'E-mail',
                    ])

        )
        ->add(
            $builder->create('Message', FormType::class, [
                'inherit_data' => true,
                'attr' => [
                    'class' => 'topformdiv',
                ],
                'label' => 'Message',
                'label_attr' => array('class' => 'topformtoplabel devis'),
            ])
                ->add('subject', TextType::class, [
                    'label' => 'Sujet',
                ])
                ->add('commentaire', TextareaType::class, [
                    'label' => 'Commentaire',
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
            'data_class' => Contact::class,
        ));
    }
}