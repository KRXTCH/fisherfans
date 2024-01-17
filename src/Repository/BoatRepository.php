<?php

namespace App\Repository;

use App\Entity\Boat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boat>
 *
 * @method Boat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boat[]    findAll()
 * @method Boat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Boat[]    findByBoundingBox(float $latitudeMin, float $latitudeMax, float $longitudeMin, float $longitudeMax)
 */
class BoatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boat::class);
    }

    /**
     * Find bateaux within a bounding box defined by latitude and longitude.
     *
     * @param float $latitudeMin
     * @param float $latitudeMax
     * @param float $longitudeMin
     * @param float $longitudeMax
     *
     * @return Boat[]
     */
    public function findByBoundingBox(float $latitudeMin, float $latitudeMax, float $longitudeMin, float $longitudeMax): array
    {
        try {
            $queryBuilder = $this->createQueryBuilder('b')
                ->andWhere('b.latitude >= :latitudeMin')
                ->andWhere('b.latitude <= :latitudeMax')
                ->andWhere('b.longitude >= :longitudeMin')
                ->andWhere('b.longitude <= :longitudeMax')
                ->setParameter('latitudeMin', $latitudeMin)
                ->setParameter('latitudeMax', $latitudeMax)
                ->setParameter('longitudeMin', $longitudeMin)
                ->setParameter('longitudeMax', $longitudeMax);

            return $queryBuilder->getQuery()->getResult();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching boats from the database: ' . $e->getMessage());
        }
    }
}
