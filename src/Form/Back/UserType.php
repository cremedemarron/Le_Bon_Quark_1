<?php

namespace App\Form\Back;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.label.email',
            ])
            ->add('roles', null, [
                'label' => 'user.label.roles',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'user.label.password',
            ])
            ->add('spaces', TextType::class, [
                'label' => 'user.label.spaces',
            ])
            ->add('homePlanet', TextType::class, [
                'label' => 'user.label.home_planet',
            ])
            ->add('galacticCredit', null, [
                'label' => 'user.label.galactic_credit',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'user.label.description',
            ])
            ->add('avatar', TextType::class, [
                'label' => 'user.label.avatar',
            ])
            ->add('psedo', TextType::class, [
                'label' => 'user.label.psedo',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'back_messages',
        ]);
    }
}
