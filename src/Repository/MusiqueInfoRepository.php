<?php

namespace App\Repository;

use App\Entity\MusiqueInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusiqueInfo>
 *
 * @method MusiqueInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusiqueInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusiqueInfo[]    findAll()
 * @method MusiqueInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiqueInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusiqueInfo::class);
    }

    public function save(MusiqueInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MusiqueInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MusiqueInfo[] Returns an array of MusiqueInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MusiqueInfo
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
