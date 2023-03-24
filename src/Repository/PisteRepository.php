<?php

namespace App\Repository;

use App\Entity\Piste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Piste>
 *
 * @method Piste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Piste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Piste[]    findAll()
 * @method Piste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piste::class);
    }

    public function save(Piste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Piste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Piste[] Returns an array of Piste objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Piste
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAllOrderByDifficulty($sort)
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.difficulte', $sort);

        return $qb->getQuery()->getResult();
    }

}
