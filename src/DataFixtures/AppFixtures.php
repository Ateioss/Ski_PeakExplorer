<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Piste;
use App\Entity\StationSki;
use App\Entity\Gdomaine;
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

        $admin = new User();
        $admin->setEmail('Philippe@example.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setFirstname('Philippe');
        $admin->setLastname('Lafontaine');

        $admin->setRoles(['ROLE_ASTATION']);

        $manager->persist($admin);

        $manager->flush();

        //Créons un domaine !

        $domain = new Gdomaine();
        $domain->setName('Domaine ');
        $manager->persist($domain);

        $manager->flush();

        //Créons des stations !

        $stations = [];
        for ($i = 1; $i <= 3; $i++) {
            $station = new StationSki();
            $station->setName('Station ' . $i);
            $station->setLocation('Location ' . $i);
            $station->setDescription('Description ' . $i);

            // Affecter une station de manière aléatoire à un domaine
            $domaine = $manager->getRepository(Gdomaine::class)->findAll()[array_rand($manager->getRepository(Gdomaine::class)->findAll())];
            $station->setDomain($domaine);

            $manager->persist($station);
            $stations[] = $station;
        }

        $manager->flush();

        // créer des pistes
        $pistes = [];
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

            // Affecter la piste à une station de manière aléatoire
            $randomStationIndex = array_rand($stations);
            $piste->setStation($stations[$randomStationIndex]);

            $manager->persist($piste);
            $pistes[] = $piste;
        }

        $manager->flush();
    }
}


