<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\CrudValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function __construct(private ManagerRegistry $registry, private ValidatorInterface $validator)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Creates or updates Product's data on SGBD
     */
    public function save(Product $product, array $data, bool $flush = false): Product
    {
        $product->setName($data['name']);
        $product->setPrice((float)$data['price']);

        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
            throw new CrudValidationException($errors);
        }
        $this->getEntityManager()->persist($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $product;
    }

    /**
     * Removes a Product object from SGBD
     */
    public function remove(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->remove($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQueryFindAll(): Query
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.name', 'ASC')
                    ->getQuery();
    }

}
