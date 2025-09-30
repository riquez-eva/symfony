<?php

namespace App\Form;


use App\Entity\Artist;
use App\Entity\Disc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;


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
                "constraints" => [
                    new File(
                        maxSize: '1024k',
                        extensions : ['png', 'jpg', 'jpeg'],
                        extensionsMessage: 'Please upload a valid picture',
                    )
                ]
            ] )
            ->add('year', IntegerType::class)
            ->add('label', TextType::class)
            ->add('genre', TextType::class)
            ->add('price', IntegerType::class)
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
