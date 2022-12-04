<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */


// Permet de filtrer les produits en fonction de la categorie, le vendeur et le prix
    public function productFilterByCategoryPriceSeller($category,$seller,$price): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category AND p.seller = :seller AND p.price <= :price')
            ->setParameter('category', $category)
            ->setParameter('seller', $seller)
            ->setParameter('price', $price)
            ->orderBy('p.created_at', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // Permet de filtrer les produits en fonction de la categorie, le vendeur et ASC and DESC
    public function productFilterByCategorySellerAscDesc($categoryName,$sellerName,$ascOrDesc): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category AND p.seller = :seller')
            ->setParameter('category', $categoryName)
            ->setParameter('seller', $sellerName)
            ->orderBy('p.created_at', $ascOrDesc)
            ->getQuery()
            ->getResult()
        ;
    }

    // Permet de recupérer tous les produits d'un vendeur
    public function getMyProducts($seller): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere(' p.seller = :seller ')
            ->setParameter('seller', $seller)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
