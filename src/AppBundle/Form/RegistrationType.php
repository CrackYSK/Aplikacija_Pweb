<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11.1.17.
 * Time: 14.30
 */

namespace AppBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Корисничко име', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Лозинка'),
                'second_options' => array('label' => 'Потврда лозинке'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'е-пошта', 'translation_domain' => 'FOSUserBundle'))
            ->add('roles', CollectionType::class, array(
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'choices' => array(
                        'Члан комисије' => 'ROLE_KOMISIJA',
                        'Администратор' => 'ROLE_ADMIN',
                    ),
                    'label' => ' '
                ),
                'label' => 'Привилегије',// 'attr' => array('class' => 'form-control'),
            ));

//        <div class="form-group" style="margin-left: 5px">
//        <label for="sort" class="col-sm-2 control-label"> Председник</label>
//        <select class="form-control" name="sort" style="width: 200px; margin-left: 100px;">
//
//
//
//        </select>
//
//    </div>

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'csrf_token_id' => 'registration',
            // BC for SF < 2.8
            'intention' => 'registration',
        ));
    }

    public function getBlockPrefix(){
        return 'app_user_registration';
    }

    public function getName(){
        return $this->getBlockPrefix();
    }

}