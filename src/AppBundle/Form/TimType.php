<?php

namespace AppBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\SrednjoskolacType;
use AppBundle\Form\StudentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['broj_clanova'] > 1)
            $builder->add('naziv', TextType::class, array('label' => 'Назив'));
        if ($options['broj_clanova'] > 0) {
            if ($options['studentska']) {
                $builder->add('ucesnik', CollectionType::class, array(
                    'entry_type' => StudentType::class,
                    'entry_options' => array(
                        'label' => ' '
                    ),
                    'label' => 'Учесници'
                ));
            } else {
                $builder->add('ucesnik', CollectionType::class, array(
                    'entry_type' => SrednjoskolacType::class,
                    'entry_options' => array(
                        'label' => ' '
                    ),
                    'label' => 'Учесници'
                ));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tim',
            'broj_clanova' => 0,
            'studentska' => 1
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tim';
    }


}
