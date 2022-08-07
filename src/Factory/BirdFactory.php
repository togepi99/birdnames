<?php

namespace App\Factory;

use App\Entity\Bird;
use App\Repository\BirdRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Bird>
 *
 * @method static Bird|Proxy createOne(array $attributes = [])
 * @method static Bird[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Bird|Proxy find(object|array|mixed $criteria)
 * @method static Bird|Proxy findOrCreate(array $attributes)
 * @method static Bird|Proxy first(string $sortedField = 'id')
 * @method static Bird|Proxy last(string $sortedField = 'id')
 * @method static Bird|Proxy random(array $attributes = [])
 * @method static Bird|Proxy randomOrCreate(array $attributes = [])
 * @method static Bird[]|Proxy[] all()
 * @method static Bird[]|Proxy[] findBy(array $attributes)
 * @method static Bird[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Bird[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BirdRepository|RepositoryProxy repository()
 * @method Bird|Proxy create(array|callable $attributes = [])
 */
final class BirdFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $createdAt = self::faker()->dateTimeBetween('-100 days', '1 day');

        return [
            'oldName' => self::faker()->colorName() . ' ' . self::faker()->word(),
            'oldNameSlugged' => null,
            'createdAt' => $createdAt,
            'updatedAt' => $createdAt,
            'images' => [],
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->beforeInstantiate(function(array $attributes) {
                if (is_int($attributes['images'])) {
                    $images = ImageFactory::createMany($attributes['images']);
                    $attributes['images'] = $images;
                }
                return $attributes;
            })
        ;
    }

    protected static function getClass(): string
    {
        return Bird::class;
    }
}
