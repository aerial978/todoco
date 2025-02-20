<?php

namespace App\Tests\Form;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testUserFormRendering(): void
    {
        $formData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'roles' => 'ROLE_USER',
            'plainPassword' => [
                'first' => 'Test@123',
                'second' => 'Test@123',
            ],
        ];

        $form = $this->factory->create(UserType::class);

        $user = new User();
        $user->setUsername($formData['username']);
        $user->setEmail($formData['email']);
        $user->setRoles([$formData['roles']]);

        $form->submit([
            'username' => $formData['username'],
            'email' => $formData['email'],
            'roles' => $formData['roles'],
            'plainPassword' => [
                'first' => $formData['plainPassword']['first'],
                'second' => $formData['plainPassword']['second'],
            ],
        ]);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user->getUsername(), $formData['username']);
        $this->assertEquals($user->getEmail(), $formData['email']);
        $this->assertEquals($user->getRoles(), [$formData['roles']]);
    }
}
