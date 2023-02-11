<?php

namespace App\Repository;

use App\Entity\TypeHoraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeHoraire>
 *
 * @method TypeHoraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHoraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHoraire[]    findAll()
 * @method TypeHoraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeHoraire::class);
    }

    public function save(TypeHoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeHoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

        // Find/search title/content
        public function findByNomTypeHoraire(string $query)
        {
            $qb = $this->createQueryBuilder('p');
            $qb
                ->where(
                    $qb->expr()->andX(
                        $qb->expr()->orX(
                            $qb->expr()->like('p.name', ':query'),
                        ),
                        $qb->expr()->isNotNull('p.id')
                    )
                )
                ->setParameter('query', '%' . $query . '%');
            return $qb
                ->getQuery()
                ->getResult();
        }
//    /**
//     * @return TypeHoraire[] Returns an array of TypeHoraire objects
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

//    public function findOneBySomeField($value): ?TypeHoraire
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
