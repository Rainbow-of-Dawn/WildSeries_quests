<?php

namespace App\DataFixtures;

use Faker;
use App\Service\Slugify;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var Slugify
     */
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=1; $i<100 ; $i++) {
            $episode = new Episode();
            $episode->setNumber($i + 1);
            $episode->setTitle($faker->sentence(5,true));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_'. floor($i/10)));
            $manager->persist($episode);
            $this->addReference('episode_'. $i, $episode);
        }
        $manager->flush();
    }
}