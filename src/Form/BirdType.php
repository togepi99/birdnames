<?php

namespace App\Form;

use App\Entity\Bird;
use App\Entity\Image;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('oldName');
        $builder->add('description', CKEditorType::class);
        $builder->add('images', CollectionType::class, [
            'entry_type' => DeleteImageType::class,
            'entry_options' => [
                'label' => false,
            ],
        ]);
        $builder->add('new_image', NewImageType::class, [
            'mapped' => false,
            'constraints' => [
                new Callback(function(Image $image, ExecutionContextInterface $context, $payload) {
                    $file = $context->getObject()->get('file')->getData();
                    if ($file && !$context->getObject()->get('alt')->getData()) {
                        $context->buildViolation('Alt text cannot be blank.')
                            ->atPath('alt')
                            ->addViolation();
                    }
                }),
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bird::class,
        ]);
    }
}
