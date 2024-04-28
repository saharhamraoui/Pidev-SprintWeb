<?php

namespace App\Repository;

use App\Entity\Donation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Donation>
 *
 * @method Donation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donation[]    findAll()
 * @method Donation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donation::class);
    }

//    /**
//     * @return Donation[] Returns an array of Donation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Donation
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByCombinedSearch(string $donator, string $campaign,int $number,int $value): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        if ($donator) {
            $queryBuilder->andWhere('e.iddonator.firstname LIKE :donator')
                ->setParameter('donator', '%' . $donator . '%');
        }

        if ($campaign) {
            $queryBuilder->andWhere('e.idcamp.titre LIKE :campaign')
                ->setParameter('campaign', '%' . $campaign . '%');
        }
        if ($number) {
            $queryBuilder->andWhere('e.iddonator.number LIKE :number')
                ->setParameter('number', '%' . $number . '%');
        }
        if ($value) {
            $queryBuilder->andWhere('e.valeurdon LIKE :value')
                ->setParameter('value', '%' . $value . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

}

