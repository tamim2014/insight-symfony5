<?php

namespace App\Form\Type;

use App\Entity\Product;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// le type de champs s'impose pour marquer un placeholder
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType; ??

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, ['attr' => ['placeholder' => 'Nom du produit']])
            ->add('price')
            //->add('description', TextType::class, ['label' => 'State']) // OK pour changer de label
            ->add('description')
            // ->add('categorie', CategorieType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'titre'
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
