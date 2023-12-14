<?php

namespace App\Repository;

use App\Entity\FishingNotebook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FishingNotebook>
 *
 * @method FishingNotebook|null find($id, $lockMode = null, $lockVersion = null)
 * @method FishingNotebook|null findOneBy(array $criteria, array $orderBy = null)
 * @method FishingNotebook[]    findAll()
 * @method FishingNotebook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishingNotebookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FishingNotebook::class);
    }

//    /**
//     * @return FishingNotebook[] Returns an array of FishingNotebook objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FishingNotebook
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
