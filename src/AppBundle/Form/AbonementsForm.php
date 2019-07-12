<?php


namespace AppBundle\Form;


use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\Offer;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class AbonementsForm extends AbstractType
{

    /** @var TranslatorInterface  */
    private $translator;

    /**
     * DevisConfigForm constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('group1', FormType::class, [
                    'label' => $this->translator->trans('societe.abonements'),
                    'inherit_data' => true,
                    'attr' => [
                        'cutom_class' => 'col-md-6',
                        'icon' => '<i class="fas fa-exclamation-triangle"></i>'

                    ],
                ])
                    ->add('typePro', EntityType::class, [
                        'class' => Offer::class,
                        'label' => $this->translator->trans('typepro')
                    ])
                    ->add('save', SubmitType::class, [
                        'label' => $this->translator->trans('save'),
                        'attr' => [
                            'class' => 'btn btn-success'
                        ]
                    ])
            )


        ;
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