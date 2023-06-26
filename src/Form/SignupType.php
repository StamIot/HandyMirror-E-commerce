<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :',
                'attr' => [
                    'placeholder' => "Veuillez saisir votre prénom ici..."
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :',
                'attr' => [
                    'placeholder' => "Veuillez saisir votre nom ici..."
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail de connexion :',
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mail ici..."
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe :',
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mot de passe ici..."
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                'label' => 'Confirmer votre mot de passe :',
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Veuillez confirmer votre mot de passe ici..."
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
