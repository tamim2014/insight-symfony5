<?php

namespace App\Form\Type;

// 2.Preciser l'entité relative à chq formulaire 
use App\Entity\Task;
use Symfony\Component\OptionsResolver\OptionsResolver;

// 3.Heriter de la "Matrice generique" des formulaires
use Symfony\Component\Form\AbstractType;

// 4.typer les champs du formulairer
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

// 5.construire enfin le formulaire
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{
    // 2.Preciser l'entité relative à chq formulaire 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class)
            ;
    }
}