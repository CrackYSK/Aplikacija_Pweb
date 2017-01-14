<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SmotraRadovaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $id=$options['dogadjaj'];

        $builder->add('dogadjaj', EntityType::class, array(
           'class'=>'AppBundle:Dogadjaj',
            'query_builder'=> function(EntityRepository $er) use ($id) {
               return $er->createQueryBuilder('d')
                   ->where('d.id ='.$id);
            }
        ))->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SmotraRadova',
            'dogadjaj'=>0
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_smotraradova';
    }


}
