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
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => "Votre prénom doit contenir au moins {{ limit }} caractères"
                    ]),
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => "Veuillez saisir votre prénom ici..."
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :',
                'constraints' => [ // Contraintes de validation
                    new Length([
                        'min' => 3, // Nombre minimum de caractères est de 3
                        'minMessage' => "Votre nom doit contenir au moins {{ limit }} caractères" // {{ limit }} est remplacé par la valeur de la propriété min
                    ]),
                    new NotBlank(),
                ],
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
                // ajoute une contrainte de 8 caractères minimum
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => "Votre mot de passe doit contenir au moins {{ limit }} caractères"
                    ]),
                    new NotBlank(),
                ],
                'label' => 'Votre mot de passe :',
                'attr' => [
                    'placeholder' => "Veuillez saisir votre mot de passe ici..."
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                // Le mot de passe doit etre minimum de 8 caractères
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => "Votre mot de passe doit contenir au moins {{ limit }} caractères"
                    ]),
                    new NotBlank(),
                ],
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
