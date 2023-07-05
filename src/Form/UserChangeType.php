<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add ('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
         
        // ->add('phone', null, [
        //     'label' => 'Téléphone',
        // ])
        // ->add('address', AddressType::class, [
        //     'label' => 'Adresse',
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
