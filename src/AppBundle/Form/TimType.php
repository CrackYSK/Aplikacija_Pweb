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
        $builder->add('naziv', TextType::class, array('label' => 'Назив'));
        for($i = 0; $i < $options['broj_clanova']; $i++) {
            $builder->add('ucesnik_' . ($i + 1), UcesnikType::class, array(
                'label' => ($i + 1) . '.члан'
            ));
            if ($options['studentska']) {
                $builder->add('student_' . ($i + 1), StudentType::class, array(
                    'label' => ' '
                ));
            } else {
                $builder->add('srednjoskolac_' . ($i + 1), SrednjoskolacType::class, array(
                    'label' => ' '
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
