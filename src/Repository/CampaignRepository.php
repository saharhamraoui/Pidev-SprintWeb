<?php

namespace App\Repository;

use App\Entity\Campaign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campaign>
 *
 * @method Campaign|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaign|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaign[]    findAll()
 * @method Campaign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campaign::class);
    }

//    /**
//     * @return Campaign[] Returns an array of Campaign objects
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

//    public function findOneBySomeField($value): ?Campaign
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByCombinedSearch(string $title, string $name, string $type, string $goal, string $number): array
{
    $queryBuilder = $this->createQueryBuilder('e');

    if ($title) {
        $queryBuilder->andWhere('e.titre LIKE :title')
            ->setParameter('title', '%' . $title . '%');
    }

    if ($name) {
        $queryBuilder->andWhere('e.associationName LIKE :name')
            ->setParameter('name', '%' . $name . '%');
    }
    if ($number) {
        $queryBuilder->andWhere('e.number LIKE :number')
            ->setParameter('number', '%' . $number . '%');
    }
    if ($type) {
        $queryBuilder->andWhere('e.campaignType LIKE :type')
            ->setParameter('type', '%' . $type . '%');
    }
    if ($goal) {
        $queryBuilder->andWhere('e.goal LIKE :goal')
            ->setParameter('goal', '%' . $goal . '%');
    }

    return $queryBuilder->getQuery()->getResult();
}


}
