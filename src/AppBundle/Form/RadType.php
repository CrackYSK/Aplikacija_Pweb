<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('naslov', TextType::class, array(
            'label' => 'Наслов'
        ))
            ->add('apstrakt', FileType::class, array(
                'label' => 'Додајте PDF апстракт рада',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Очекује се апстракт у PDF формату!',
                    ])
                ]
            ))
            ->add('autor', CollectionType::class, array(
                'entry_type' => AutorType::class,
                'entry_options' => array(
                    'label' => ' '
                ),
                'label' => 'Аутори'
            ))->add('dodaj', ButtonType::class, array(
                'label' => 'Додај аутора',
                'attr' => array(
                    'class' => 'btn btn-primary btn-xs'
                )
            ));

            $builder->add('ukloni', ButtonType::class, array(
                'label' => 'Уклони аутора',
                'attr' => array(
                    'class' => 'btn btn-danger btn-xs'
                )
            ));
            $builder->add('broj', HiddenType::class, array(
                'mapped' => false,
                'attr' => array(
                    'value' => 0,
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Пријави рад',
                'attr' => array(
                    'class' => 'btn btn-success btn-lg'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rad',
            'manager' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_rad';
    }


}
