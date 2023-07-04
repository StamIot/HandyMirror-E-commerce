<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', null, [
            'label' => 'Prénom',
        ])
        ->add('lastname', null, [
            'label' => 'Nom',
        ])
        ->add('email', null, [
            'label' => 'Email',
        ])
        ->add('phone', null, [
            'label' => 'Téléphone',
        ])
        ->add('address', AddressType::class, [
            'label' => 'Adresse',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
