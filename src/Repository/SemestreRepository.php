<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\Semestre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Json;
use function MongoDB\BSON\toJSON;

/**
 * @extends ServiceEntityRepository<Semestre>
 */
class SemestreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Semestre::class);
    }

    //    /**
    //     * @return Semestre[] Returns an array of Semestre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Semestre
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findEtudiantNotes($etudiantId)
    {
        // On commence en sélectionnant l'entité principale 'Etudiant' (alias 'e')
        $qb = $this->getEntityManager()->createQueryBuilder();

        // La requête commence avec l'entité 'Etudiant'
        $qb->select('e,n,m,s')
            ->from(Etudiant::class, 'e')  // Spécifier l'entité principale (Etudiant)
            ->join('e.notes', 'n')  // Joindre les notes via l'étudiant
            ->join('n.matiere', 'm')  // Joindre les matières via les notes
            ->join('m.semestre', 's')  // Joindre les semestres via les matières
            ->where('e.id = :etudiantId')  // Filtrer pour l'ID de l'étudiant
            ->setParameter('etudiantId', $etudiantId)
            ->orderBy('s.libelle', 'ASC')
            ->addOrderBy('m.intitule', 'ASC');

        // Utiliser getArrayResult pour obtenir un tableau associatif, qui peut être transformé en JSON
        return $qb->getQuery()->getArrayResult();
    }


}
