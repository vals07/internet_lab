<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Логин'
            ])
            ->add('name', TextType::class, [
                'label' => 'Имя'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Фамилия'
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
            ])
           // ->add('roles')
        /*    ->add('password')
            ->add('plainPassword')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
?>