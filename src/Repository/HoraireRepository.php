<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Horaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Horaire>
 *
 * @method Horaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaire[]    findAll()
 * @method Horaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaire::class);
    }

    public function save(Horaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Horaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // recherche
    /**
     * récupère les horaires en lien avec une recherche
     *
     * @return Horaire[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            // selectionne toutes les infos qui sontliés aux types d'horaires mais aussi aux horaires
            ->select('c', 'p')
            ->join('p.typeHoraire', 'c');


        if (!empty($search->q)) {
            $query = $query
                // on veut que le nom de l'horaire (p.name) soit comme le parametre (q)
                ->andWhere('p.name Like :q')
                // % permet de faire des recherches partielles
                ->setParameter('q', "%{$search->q}%");
        }

        // on gere les horaires
        if (!empty($search->typeHoraire)) {
            $query = $query
                ->andWhere('c.id IN (:typeHoraire)')
                ->setParameter('typeHoraire', $search->typeHoraire);
        }

        if (!empty($search->priority)) {
            $query = $query
                // ->andWhere('c.id IN (:priority)')
                // ->setParameter('priority', $search->priority)
                ->andWhere('p.priority IN (:priority)')
                -> setParameter('priority', $search->priority)
                
                
                ;
        }




        return $query->getQuery()->getResult();
    }


    //    /**
    //     * @return Horaire[] Returns an array of Horaire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Horaire
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
