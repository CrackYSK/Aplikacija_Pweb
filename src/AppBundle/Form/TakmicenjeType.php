<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TakmicenjeType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['manager'];
        $kategorije = $em->getRepository('AppBundle:Kategorija')->findAll();
        $id=$options['dogadjaj'];

        $builder->add('dogadjaj', EntityType::class, array(
            'class' => 'AppBundle:Dogadjaj',
            'query_builder' => function (EntityRepository $er) use ($id) {
                return $er->createQueryBuilder('d')
                    ->where('d.id = '.$id );
            }
        ))
            ->add('kategorija', EntityType::class, array(
            'class' => 'AppBundle:Kategorija',
            'choices' => $kategorije
        ))
            ->add('save', SubmitType::class,array(
                'attr' => array('class' => 'btn-success btn')
            ));
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Takmicenje',
            'manager' => null,
            'dogadjaj' => 0
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_takmicenje';
    }


}
