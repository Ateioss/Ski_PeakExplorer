<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Piste;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}

    /**
     * @throws \Exception
     */
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

        // créer des pistes
        for ($i = 1; $i <= 3; $i++) {
            $piste = new Piste();
            $piste->setName('Piste ' . $i);
            $difficulte = rand(1, 3);
            switch ($difficulte) {
                case 1:
                    $piste->setDifficulte('Facile');
                    break;
                case 2:
                    $piste->setDifficulte('Moyen');
                    break;
                case 3:
                    $piste->setDifficulte('Difficile');
                    break;
            }
            $piste->setOuverture(rand(0, 1));

            $piste->setBlock(0);

            $ouverture = new \DateTime('8:00');
            $fermeture = new \DateTime('19:00');

            $piste->setHoraireOuverture($ouverture);
            $piste->setHoraireFermeture($fermeture);

            $manager->persist($piste);
        }

        $manager->flush();
    }
}
