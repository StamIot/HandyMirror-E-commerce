<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction("/signup")
            ->setMethod("post")
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :',
                'help' => "Minimum 3 caractères",
                'required' => true,
                'trim' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre prénom ici..."
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => "Votre prénom doit contenir au moins {{ limit }} caractères."
                    ]),
                    new NotBlank(),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :',
                'help' => "Minimum 3 caractères",
                'required' => true,
                'trim' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre nom ici..."
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => "Votre nom doit contenir au moins {{ limit }} caractères"
                    ]),
                    new NotBlank(),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail de connexion :',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mail ici..."
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mot de passe ici..."
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.',
                    ]),
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                'mapped' => false,
                'label' => 'Confirmez votre mot de passe',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => "Veuillez confirmer votre mot de passe ici..."
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.',
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
