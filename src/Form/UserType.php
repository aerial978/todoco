<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $includePlaceholder = $options['includePlaceholder'];

        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => 'Username',
                'label_attr' => [
                    'class' => 'form-label mt-4 custom-label-color',
                ],
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4 custom-label-color',
                ],
                'empty_data' => '',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Rôles',
                'label_attr' => [
                    'class' => 'form-label mt-4 custom-label-color',
                ],
                'expanded' => false,
                'multiple' => false,
                'mapped' => true,
                'data' => $options['data']->getRoles()[0] ?? 'ROLE_USER',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords do not match !',
                'options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => $includePlaceholder ? '***********' : null,
                ],
                    'label_attr' => ['class' => 'form-label mt-4 custom-label-color'],
                ],
                'required' => false,
                'first_options' => [
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Password Confirmation',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'includePlaceholder' => true,
        ]);
    }
}
