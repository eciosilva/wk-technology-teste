<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function getQueryFindAll(): Query
    {
        return $this->createQueryBuilder('o')
                    ->orderBy('o.createdAt', 'ASC')
                    ->getQuery();
    }

    public function save(Order $order, array $data, bool $flush = false): void
    {
        $customer = $this->getEntityManager()->getPartialReference(Customer::class, $data['customer']['id']);
        $order->setCustomer($customer);
        $order->setCreatedAt(new \DateTime());
        $this->getEntityManager()->persist($order);

        $totalOrderValue = 0;
        foreach ($data['orderProducts'] as $orderProductData) {

            if (0 == $orderProductData['amount']) {
                continue;
            }

            /** @var Product */
            $product = $this->getEntityManager()->getRepository(Product::class)->find($orderProductData['product']['id']);

            $itemValue = (float) $orderProductData['product']['price'];
            $totalPerItem = ((int) $orderProductData['amount']) * $itemValue;
            $totalOrderValue += $totalPerItem;

            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProduct($product);
            $orderProduct->setUnitValue($itemValue);
            $orderProduct->setAmount((int)$orderProductData['amount']);
            $orderProduct->setTotalValue($totalPerItem);

            $this->getEntityManager()->persist($orderProduct);
        }

        $order->setTotalValue($totalOrderValue);

        if ($flush) {
            $this->getEntityManager()->refresh($customer);
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $order, bool $flush = false): void
    {
        $this->getEntityManager()->remove($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
