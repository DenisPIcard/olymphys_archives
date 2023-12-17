<?php

namespace App\Repository;

use App\Entity\TblPaths;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TblPaths>
 *
 * @method TblPaths|null find($id, $lockMode = null, $lockVersion = null)
 * @method TblPaths|null findOneBy(array $criteria, array $orderBy = null)
 * @method TblPaths[]    findAll()
 * @method TblPaths[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TblPathsRepository extends EntityRepository
{


//    /**
//     * @return TblPaths[] Returns an array of TblPaths objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TblPaths
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
