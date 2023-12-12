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
use Symfony\Component\Validator\Constraints as Assert;

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
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter a username !',
                    ]),
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
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter an email address !',
                    ]),
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
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select a role !',
                    ]),
                ],
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
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter a password !',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/',
                        'message' => 'Your password must contain at least 8 characters, one lowercase letter, one uppercase letter, one number and one special character !',
                    ]),
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
