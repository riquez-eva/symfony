<?php

namespace App\Form;


use App\Entity\Disc;
use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class DiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "constraints" => [
                    new NotBlank([], "Remplis ce champ!!!!!!!!!!!")
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image du disque',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'onchange' => 'previewImage(event)', // ✅ JS pour la preview
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [                 // ✅ pas "extensions" mais "mimeTypes"
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid picture (JPG ou PNG)',
                    ])
                ],
            ])
            ->add('year', IntegerType::class)
            ->add('label', TextType::class, [
                "constraints" => [
                    new NotNull([], "Remplis ce champ!!!!!!!!!!!")
                ]
            ])
            ->add('genre', TextType::class, [
                "constraints" => [
                    new NotNull([], "Remplis ce champ!!!!!!!!!!!")
                ]
            ])
            ->add('price', IntegerType::class, [
                "constraints" => [
                    new NotNull([], "Remplis ce champ!!!!!!!!!!!")
                ]
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
            ])
            ->add("Enregistrer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disc::class,
            "attr" => ["novalidate" => "novalidate"]
        ]);
    }
}
