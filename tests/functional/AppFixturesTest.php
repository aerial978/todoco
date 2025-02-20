<?php

namespace App\Tests\DataFixtures;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use App\DataFixtures\AppFixtures;
use App\Entity\User;
use App\Entity\Task;

class AppFixturesTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        // Charger les fixtures via le DoctrineFixturesBundle
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        
        $loader = new Loader();
        $loader->addFixture(new AppFixtures(self::getContainer()->get('security.password_hasher')));

        $purger = new ORMPurger();
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testFixturesLoad(): void
    {
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');

        // Vérification si les utilisateurs ont été correctement persistés
        $userRepository = $entityManager->getRepository(User::class);
        $users = $userRepository->findAll();
        $this->assertGreaterThanOrEqual(1, $users, 'Les utilisateurs doivent être chargés correctement.');

        // Vérification si les tâches ont été correctement persistées
        $taskRepository = $entityManager->getRepository(Task::class);
        $tasks = $taskRepository->findAll();
        $this->assertGreaterThanOrEqual(1, $tasks, 'Les tâches doivent être chargées correctement.');
    }
}
