<?php

namespace App\DataFixtures;

use App\Entity\Remontee;
use App\Entity\User;
use App\Entity\Piste;
use App\Entity\StationSki;
use App\Entity\Gdomaine;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        //Créons un utilisateur




        //Créons un domaine !

        $domain = new Gdomaine();
        $domain->setName('Espace Diamant ');
        $manager->persist($domain);

        $manager->flush();

        $Email_station = array('LesSaisies@gmail.com' , 'CrestVolantCohennoz@gmail.com', 'NotreDamedeBellecombe@gmail.com' , 'PrazsurArly@gmail.com' , 'Flumet@gmail.com');
        $name_station = array('Les Saisies' , 'Crest Volant Cohennoz' , 'Notre Dame de Bellecombe' , 'Praz sur Arly' , 'Flumet');
        //Créons des stations !

        for ( $i = 0 ; $i < 5 ; $i++ ){
            $Astation = new User();
            $Astation->setEmail($Email_station[$i]);
            $Astation->setPassword($this->passwordHasher->hashPassword($Astation, 'password'));
            $Astation->setFirstname($name_station[$i]);
            $Astation->setLastname('Admin');
            $Astation->setRoles(['ROLE_ASTATION']);
            $manager->persist($Astation);


        }
        $manager->flush();



        $users = $manager->getRepository(User::class)->findAll();
        $domain = $manager->getRepository(Gdomaine::class)->findAll();

        //création des stations

        foreach($users as $statione){
            $station = new StationSki();
            $station->setName($statione->getFirstname());
            $station->setDomain($domain[rand(0 , count($domain)-1)]);
            $station->setLocation('France');
            $station->setDescription('lorem ipsum');
            $station->setOwner($statione);
            $manager->persist($station);
        }
        $manager->flush();


        $stationrepository = $manager->getRepository(StationSki::class)->findAll();


       //création des pistes
       $difficulte = array('Verte' , 'Bleu' , 'Rouge', 'Noir');

        for ( $i = 0 ; $i < 15 ; $i++ ){
            $piste = new Piste();
            $piste->setName('Piste '.$i);
            $piste->setDifficulte($difficulte[rand(0 , count($difficulte)-1)]);
            $piste->setOuverture(false);
            $ouverture = new \DateTime('8:00');
            $fermeture = new \DateTime('18:00');
            $piste->setHoraireOuverture($ouverture);
            $piste->setHoraireFermeture($fermeture);
            $piste->setBlock(false);
            $piste->setStation($stationrepository[rand(0 , count($stationrepository)-1)]);
            $manager->persist($piste);

        }
        $manager->flush();

        //création des remontées mécaniques

        for ( $i = 0 ; $i < 15 ; $i++ ){
            $remonte = new Remontee();
            $remonte->setName('Remonte '.$i);
            $remonte->setOpen(false);
            $ouverture = new \DateTime('8:00');
            $fermeture = new \DateTime('18:00');
            $remonte->setOpenTime($ouverture);
            $remonte->setCloseTime($fermeture);
            $remonte->setBlock(false);
            $remonte->setStation($stationrepository[rand(0 , count($stationrepository)-1)]);
            $manager->persist($remonte);
            $manager->flush();
        }


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

    }
}


