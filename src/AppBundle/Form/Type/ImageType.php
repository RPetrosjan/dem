<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 12/01/2019
 * Time: 02:14
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Image;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    protected $resolver;

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder
            ->add('filename', HiddenType::class, array(

                'required' => false,

                'attr' => array(

                    'data' => 'nameImage'

                ),

            ))
            ->add('path', HiddenType::class, array(

                'required' => false,

                'attr' => array(

                    'data' => 'pathImage'

                )

            ))
            ->add('file', 'file', array(

                'label' => 'Ajoter Image',

                'required' => false,

                'attr' => array(

                    'data' => 'fileImage',
                    'class' => 'fileimage',

                ),

            ))
            ->add('altimage', TextType::class, array(

                'label' => 'Enter Image Alt',

            ))
            ->add('title', TextType::class, array(

                'label' => 'Enter TitleImage'

            ))
            ->add('description', TextareaType::class, array(

                'label' => 'Enter Description'

            ))
            ->add('url', TextType::class, array(

                'label' => 'Enter url to page',

                'required' => false,

                'empty_data' => '',

            ));

    }


    public function configureOptions(OptionsResolver $resolver)

    {

        $resolver->setDefaults(array(

            'data_class' => Image::class,

        ));


        $this->resolver = $resolver;

    }
}