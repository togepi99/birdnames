<?php

namespace App\File;

use App\Entity\Image;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    private string $imageDirectory;

    public function __construct(ParameterBagInterface $parameterBag, private readonly SluggerInterface $slugger)
    {
        $this->imageDirectory = (string)$parameterBag->get('image_directory');
    }

    public function prepareFileAndSetOnImage(UploadedFile $file, Image $image): void
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->imageDirectory, $fileName);
            $image->setFilename($fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
    }

    public function removeFileFor(Image $image): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove([$this->imageDirectory . '/' . $image->getFilename()]);
    }
}