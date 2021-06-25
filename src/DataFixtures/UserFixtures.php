<?php

namespace App\DataFixtures;

use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('Test');
        $user->setLastName('Administrator');
        $user->setPassword($this->hasher->hashPassword($user, 'P@ssw0rd'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setFirstName('First');
        $user->setLastName('User');
        $user->setPassword($this->hasher->hashPassword($user, 'fP111111'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $user = new User();
        $user->setFirstName('Second');
        $user->setLastName('User');
        $user->setPassword($this->hasher->hashPassword($user, 'sP222222'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $phoneNumber = new PhoneNumber();
        $phoneNumber->setPhoneNumber("+3805012345678");
        $user->addPhoneNumber($phoneNumber);
        $manager->persist($phoneNumber);

        $phoneNumber = new PhoneNumber();
        $phoneNumber->setPhoneNumber("+3805012342344");
        $user->addPhoneNumber($phoneNumber);
        $manager->persist($phoneNumber);

        $manager->flush();
    }
}
