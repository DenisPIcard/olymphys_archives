<?php

namespace App\Repository;


use App\Entity\TblFichiers;
use App\Entity\TblPaths;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TblFichiers>
 *
 * @method TblFichiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TblFichiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TblFichiers[]    findAll()
 * @method TblFichiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TblFichiersRepository extends EntityRepository
{


    public function getPathString($path) :string
    {



        $pathString=$path->getName().'/';

        while($path->getRang()!=0){

            $pathString=$path->getDirectory()->getName().'/'.$pathString;
            $path=$path->getDirectory();

        }
        return $pathString;

    }
}
