<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $news, bool $flush = false): void
    {
        $this->getEntityManager()->persist($news);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $news, bool $flush = false): void
    {
        $this->getEntityManager()->remove($news);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return News[] Returns an array of all news, order by creation date (newest)
     */
    public function findAll(): array
    {
        $query = $this->createQueryBuilder('news');
        $news = $query->select()
            ->orderBy('news.created_at', 'DESC')
            ->getQuery()
            ->getResult();
        return $news;
    }

    /**
     * @return News[] Returns an array of last 3 news articles
     */
    public function findLatest(): array
    {
        $query = $this->createQueryBuilder('news');
        $news = $query->select()
            ->orderBy('news.created_at', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
        return $news;
    }

    //    /**
    //     * @return News[] Returns an array of News objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?News
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
