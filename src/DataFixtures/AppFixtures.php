<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}

    public function load(ObjectManager $manager): void
    {
        //Créons un utilisateur
        $user = new User();
        $user->setEmail('francisbertrand@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setFirstname('Francis');
        $user->setLastname('Bertrand');

        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $manager->flush();

        //Créons un admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setFirstname('Admin');
        $admin->setLastname('Admin');

        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();

        //Créons un commerçant

        $Station = new User();
        $Station->setEmail('philippe.lafont@gmail.com');
        $Station->setPassword($this->passwordHasher->hashPassword($Station, 'password'));
        $Station->setFirstname('Philippe');
        $Station->setLastname('Lafont');

        $Station->setRoles(['ROLE_ASTATION']);

        $manager->persist($Station);

        $manager->flush();

        $manager->flush();

        //Créons des defis !


    }
}
