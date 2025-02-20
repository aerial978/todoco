<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => false,
            'label' => 'Title',
            'label_attr' => [
                'class' => 'form-label mt-4 fw-bold fs-6 custom-label-color',
            ],
            'empty_data' => '',
        ])
        ->add('content', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => false,
            'label' => 'Content',
            'label_attr' => [
                'class' => 'form-label mt-4 fw-bold fs-6 custom-label-color',
            ],
            'empty_data' => '',
        ]);

        if ($options['display_isDone']) {
            $builder->add('isDone', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label' => 'Is Done',
                'label_attr' => [
                    'class' => 'form-check-label fw-bold custom-label-color custom-checkbox',
                ],
                'row_attr' => [
                    'class' => 'mt-4',
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'display_isDone' => true,
        ]);
    }
}
