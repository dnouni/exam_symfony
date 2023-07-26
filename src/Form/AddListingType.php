<?php

namespace App\Form;

use App\Entity\Listing;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AddListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextType::class, [
            'label' => 'Description'
            ])
            ->add('producedYear', IntegerType::class,[
                'label' => 'Année de mise en circulation'
            ])
            ->add('mileage', IntegerType::class,[
                'label' => 'Kilométrage'
            ])
            ->add('price', IntegerType::class,[
                'label' => 'Prix'
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création'
            ])
            ->add('image', FileType::class,[
                'label' => 'form.user.profile_image.label',
                'required' => false,
                'mapped' => false, // => Dit à Symfony : t'inquiètes, je le gère moi-même
                'constraints' => [
                    new File(
                        maxSize: '3M',
                        mimeTypes: ['image/png', 'image/jpeg'],
                        maxSizeMessage: 'Ton fichier est trop lourd !',
                        mimeTypesMessage: 'Déposer seulement un .jpg ou .png'
                    )
                ]
            ])
            ->add('model')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
