<?php

namespace App\EventListener;

use App\Entity\Image;
use App\File\ImageUploader;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ImageDeleteListener
{
    public function __construct(private readonly ImageUploader $imageUploader)
    {
    }

    public function postRemove(Image $image, LifecycleEventArgs $lifecycleEventArgs): void
    {
        $this->imageUploader->removeFileFor($image);
    }
}