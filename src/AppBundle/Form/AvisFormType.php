<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 27/09/2018
 * Time: 00:04
 */

namespace AppBundle\Form;


use AppBundle\Entity\AvisSociete;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder->add(
            $builder->create('Societe_Avis', FormType::class, [
                'inherit_data' => true,
                'attr' => [
                    'class' => 'topformdiv',
                ],
                'label' => ' ',
                'label_attr' => array('class' => 'topformtoplabel devis'),
            ])
                ->add('societe', TextType::class, [
                    'label' => 'Nom Societe',
                    'attr' => array(
                        'class' => 'societe_ajax',
                    ),
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
            'data_class' => AvisSociete::class,
        ));
    }
}