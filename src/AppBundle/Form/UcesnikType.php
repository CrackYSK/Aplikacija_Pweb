<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UcesnikType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ime', TextType::class, array(
            'label' => 'Име'
        ))->add('prezime', TextType::class, array(
            'label' => 'Презиме'
        ))->add('email', EmailType::class, array(
            'label' => 'е-пошта'
        ))->add('prethodnaIskustva', TextareaType::class, array(
            'label' => 'Претходна искуства'
        ))->add('cv', FileType::class, array(
            'label' => 'Додајте CV-образац',
            'constraints' => [
                new File([
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Очекује се CV-образац у PDF формату!',
                ])
            ]
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ucesnik',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ucesnik';
    }


}
