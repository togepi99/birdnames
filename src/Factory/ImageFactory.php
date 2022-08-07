<?php

namespace App\Factory;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Image>
 *
 * @method static Image|Proxy createOne(array $attributes = [])
 * @method static Image[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Image|Proxy find(object|array|mixed $criteria)
 * @method static Image|Proxy findOrCreate(array $attributes)
 * @method static Image|Proxy first(string $sortedField = 'id')
 * @method static Image|Proxy last(string $sortedField = 'id')
 * @method static Image|Proxy random(array $attributes = [])
 * @method static Image|Proxy randomOrCreate(array $attributes = [])
 * @method static Image[]|Proxy[] all()
 * @method static Image[]|Proxy[] findBy(array $attributes)
 * @method static Image[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Image[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ImageRepository|RepositoryProxy repository()
 * @method Image|Proxy create(array|callable $attributes = [])
 */
final class ImageFactory extends ModelFactory
{
    public const BIRD_IMAGE_FILENAMES = [
        'bairds-sparrow.jpg',
        'clarks-grebe.jpg',
        'gambels-quail.jpg',
        'nelsons-sharp-tailed-sparrow.jpg',
        'nuttalls-woodpecker.jpg',
        'rosss-goose.jpg',
        'stellers-jay.jpg',
        'townsends-solitaire.jpg',
        'townsends-warbler.jpg',
        'wilsons-snipe.jpg',
        'wilsons-storm-petrel.jpg',
        'wilsons-warbler.jpg',
    ];
    private Filesystem $filesystem;
    private string $imageUploadsDirectory;
    private string $birdImageDirectory;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        parent::__construct();
        $this->filesystem = new Filesystem();
        $this->imageUploadsDirectory = $parameterBag->get('image_directory');
        $this->birdImageDirectory = $parameterBag->get('kernel.project_dir') . '/src/DataFixtures/Images';
    }

    protected function getDefaults(): array
    {
        return [
            'filename' => self::faker()->randomElement(self::BIRD_IMAGE_FILENAMES),
            'alt' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        return $this
             ->afterInstantiate(function(Image $image): void {
                 $filename = $image->getFilename();
                 $newFilename = uniqid() . '-' . $filename;
                 $this->filesystem->copy(
                     $this->birdImageDirectory . '/' . $filename,
                     $this->imageUploadsDirectory . '/' . $newFilename
                 );
                 $image->setFilename($newFilename);
             })
        ;
    }

    protected static function getClass(): string
    {
        return Image::class;
    }
}
