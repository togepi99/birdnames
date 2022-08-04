<?php

namespace App\DataFixtures;

use App\Factory\BirdFactory;
use App\Factory\BirdNameFactory;
use App\Factory\UserFactory;
use App\Factory\VoteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        BirdFactory::createMany(10);

        UserFactory::createMany(20);

        UserFactory::createOne([
            'roles' => [ 'ROLE_ADMIN' ]
        ]);

        BirdNameFactory::createMany(50, function () {
            return [
                'bird' => BirdFactory::random(),
                'creator' => UserFactory::random(),
            ];
        });

        VoteFactory::createMany(250, function () {
            return [
                'birdName' => BirdNameFactory::random(),
                'voter' => rand(1, 2) === 1 ? UserFactory::random() : null,
            ];
        });


        $manager->flush();
    }
}
