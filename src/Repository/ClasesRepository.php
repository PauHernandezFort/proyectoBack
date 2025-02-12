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
     * Busca clases por fecha
     * 
     * @param \DateTime $fecha La fecha a buscar
     * @return Clases[] Un array con las clases encontradas
     */
    public function findByFecha(\DateTime $fecha): array
    {
        // Crear el inicio y fin del día para buscar todas las clases de ese día
        $inicioDia = clone $fecha;
        $inicioDia->setTime(0, 0, 0);
        
        $finDia = clone $fecha;
        $finDia->setTime(23, 59, 59);

        return $this->createQueryBuilder('c')
            ->andWhere('c.fecha BETWEEN :inicio AND :fin')
            ->setParameter('inicio', $inicioDia)
            ->setParameter('fin', $finDia)
            ->orderBy('c.fecha', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
