<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ImageUploadExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('image_upload_path', [$this, 'makeImageUploadPath']),
        ];
    }

    public function makeImageUploadPath($filename): string
    {
        return '/uploads/images/' . $filename;
    }
}
