<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
    public function load(ObjectManager $manager): void
    {    
        for ($i = 1; $i < 10; ++$i) {
            $user = new User();
            $user->setUsername($this->faker->name());
            $user->setEmail($this->faker->email());
            $user->setRoles(['ROLE_USER']);
            $user->setPlainPassword('password');

            $manager->persist($user);
        }
        
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
