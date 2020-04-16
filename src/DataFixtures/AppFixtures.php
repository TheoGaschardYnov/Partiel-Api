<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $styles = [];

        for ($i = 0; $i < 10; $i++) {
            $style = new Style();
            $style->setName($faker->sentence($nbWords = 1, $variableNbWords = false));

            $manager->persist($style);
            $styles[] = $style;
        };

        for ($x = 0; $x < 30; $x++) {
            $artist = new Artist();
            $artist->setName($faker->sentence($nbWords = 3, $variableNbWords = true))
                ->setStartYear($faker->numberBetween(1900, 2019))
            
            ;
            $number = $faker->numberBetween(1, 5);
            for ($y = 0; $y < $number; $y++) {
                $artist->addStyle(
                    $styles[$faker->numberBetween(0, count($styles) - 1)]);
            };

            $number = $faker->numberBetween(1, 10);
            for ($y = 0; $y < $number; $y++) {
                $album = new Album();
                $album->setName($faker->sentence($nbWords = 2, $variableNbWords = false))
                    ->setReleaseYear($faker->numberBetween(1900, 2019));
                $artist->addAlbum($album);
            };


            $manager->persist($artist);
        };


        $manager->flush();
    }
}
