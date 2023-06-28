<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LogInFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email de connexion :',
                'required' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mail ici..."
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe :',
                'required' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mot de passe ici..."
                ]
            ]);
    }
}
