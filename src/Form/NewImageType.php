<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class NewImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new Image([
                    'minWidth' => 640,
                    'minHeight' => 420,
                ]),
            ],
            'help' => 'Please compress your images with <a href="https://squoosh.app/">squoosh</a> before adding them.',
            'help_html' => true,
        ]);

        $builder->add('alt', TextareaType::class, [
            'required' => false,
        ]);

        $builder->add('attribution', TextType::class, [
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Image::class,
        ]);
    }
}