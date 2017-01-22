<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\Query\ResultSetMapping;

class DogadjajType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em=$options['manager']->getRepository('AppBundle:User');
        $query = $em->createQueryBuilder('s')
                    ->select('u')
                    ->from('AppBundle:User', 'u')
                    ->where('u.roles LIKE :id')
                    ->setParameter('id', '%ROLE_KOMISIJA%')
                    ->getQuery();
        $komisija = $query->getResult();


        $builder->add('ime',null,  array('label' => 'Назив'))
            ->add('datum',null,  array('label' => 'Датум'))
            ->add('predsednik', EntityType::class, array(
                'class' => 'AppBundle:User',
                'choices' => $komisija,
                'label' => 'Председник'
            ))
            ->add('save', SubmitType::class,array(
                'attr' => array('class' => 'btn-success btn-sm'),'label' => 'Сачувај'
            ));
        //,array('label' => 'Сачувај')
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dogadjaj',
            'manager' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dogadjaj';
    }


}
