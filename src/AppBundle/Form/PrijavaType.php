<?php

namespace AppBundle\Form;

use AppBundle\Entity\Takmicenje;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PrijavaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $takmicenja = $options['manager']->getRepository('AppBundle:Takmicenje')->findAll();

        $builder->add('takmicenje', EntityType::class, array(
            'class' => 'AppBundle:Takmicenje',
            'choices' => $takmicenja,
            'placeholder' => 'Изаберите категорију',
            'label' => 'Такмичење'
        ));
        $builder->add('tim', TimType::class, array(
            'broj_clanova' => $options['broj_clanova'],
            'studentska' => $options['studentska'],
            'label' => 'Тим:'
        ));

        $builder->add('SACUVAJ', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prijava',
            'manager' => null,
            'broj_clanova' => 0,
            'studentska' => 1
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_prijava';
    }


}
