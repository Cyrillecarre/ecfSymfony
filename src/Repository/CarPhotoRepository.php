<?php

namespace App\Repository;

use App\Entity\CarPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarPhoto>
 *
 * @method CarPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarPhoto[]    findAll()
 * @method CarPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarPhoto::class);
    }

    //    /**
    //     * @return CarPhoto[] Returns an array of CarPhoto objects
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

    //    public function findOneBySomeField($value): ?CarPhoto
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
