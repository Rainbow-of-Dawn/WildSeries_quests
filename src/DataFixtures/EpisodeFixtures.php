<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=1; $i<100 ; $i++) {
            $episode = new Episode();
            $episode
                ->setNumber($i + 1)
                ->setTitle($faker->sentence(5,true))
                ->setSynopsis($faker->text)
                ->setSeason($this->getReference('season_'. floor($i/10)));
            $manager->persist($episode);
            $this->addReference('episode_'. $i, $episode);
        }
        $manager->flush();
    }
}