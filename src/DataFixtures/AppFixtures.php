<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public Generator $faker;
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager): void
    {    
        for ($i=0; $i <= 10; $i++) {
            $task = new Task();
            $task->setTitle($this->faker->word());
            $task->setContent($this->faker->sentence());
            $task->setIsDone(mt_rand(0, 1) == 1 ? true :false);
            $task->setUser(null);

            $manager->persist($task);
        }

        $manager->flush();    
    }
}
