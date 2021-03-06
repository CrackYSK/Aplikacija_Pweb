<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class KategorijaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('naziv',null,  array('label' => 'Назив'))
            ->add('brojTimova',null,  array('label' => 'Број тимова'))
            ->add('brojClanovaTima',null,  array('label' => 'Број чланова тима'))
            ->add('studentska',null,  array('label' => 'Студентска'))
            ->add('save', SubmitType::class,array(
                'attr' => array('class' => 'btn-success btn'),'label' => 'Сачувај'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Kategorija'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_kategorija';
    }


}
