<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pictureFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'delete_label' => 'Supprimer l\'image ?',
                'download_label' => 'Agrandir l\'image'
            ])
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'fullSection'
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date de publication'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
