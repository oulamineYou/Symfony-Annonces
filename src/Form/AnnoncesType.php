<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, ['attr' => ['class' => 'form-control mb-3 mt-1']])
            ->add('content', CKEditorType::class, ['attr' => ['class' => 'form-control mb-3 mt-1']])
            ->add('categorie', EntityType::class,  
                    ['class' => Categorie::class,
                    'attr' => ['class' => 'form-control mb-3 mt-1']])
            ->add('ajouter', SubmitType::class, ['attr' => ['class' => 'btn blue press m-2']])
                    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
