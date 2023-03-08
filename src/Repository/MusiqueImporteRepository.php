<?php

namespace App\Repository;

use App\Entity\MusiqueImporte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusiqueImporte>
 *
 * @method MusiqueImporte|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusiqueImporte|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusiqueImporte[]    findAll()
 * @method MusiqueImporte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiqueImporteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusiqueImporte::class);
    }

    public function save(MusiqueImporte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MusiqueImporte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MusiqueImporte[] Returns an array of MusiqueImporte objects
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

//    public function findOneBySomeField($value): ?MusiqueImporte
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
