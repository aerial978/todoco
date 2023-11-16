<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; ++$i) {
            $task = new Task();
            $task->setTitle($this->faker->word());
            $task->setContent($this->faker->sentence());
            $task->setIsDone(1 == mt_rand(0, 1) ? true : false);
            $task->setUser(null);

            $manager->persist($task);
        }

        $manager->flush();
    }
}
