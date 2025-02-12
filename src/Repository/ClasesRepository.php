<?php

namespace App\Repository;

use App\Entity\Clases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clases>
 */
class ClasesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clases::class);
    }

    //    /**
    //     * @return Clases[] Returns an array of Clases objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Clases
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Clases[] Returns an array of Clases objects
     */
    public function findByNombre(string $nombre): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nombre LIKE :nombre')
            ->setParameter('nombre', '%' . $nombre . '%')
            ->orderBy('c.fecha', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
