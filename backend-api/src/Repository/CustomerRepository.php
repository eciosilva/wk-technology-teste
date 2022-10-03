<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Customer;
use App\Service\CrudValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(private ManagerRegistry $registry, private ValidatorInterface $validator)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * Creates or updates Customer's data on SGBD
     */
    public function save(Customer $customer, array $data, bool $flush = false): Customer
    {
        $customer->setName(trim($data['name'], "\xC2\xA0\t \n\r\t\v\0"));
        $customer->setEmail($data['email']);
        $customer->setCpf($data['cpf']);
        $customer->setBirthdate($data['birthdate']);

        $errors = $this->validator->validate($customer);

        foreach( $data['address'] as $addressData) {

            if (isset($addressData['id']) && !empty($addressData['id'])) {
                $address = $this->registry->getRepository(Address::class)->find($addressData['id']);
            } else {
                $address = new Address();
            }

            $city = $this->getEntityManager()->getPartialReference(City::class, (int)$addressData['city']);

            $address->setStreet($addressData['street']);
            $address->setComplement($addressData['complement']);
            $address->setDistrict($addressData['district']);
            $address->setNumber($addressData['number']);
            $address->setZip($addressData['zip']);
            $address->setCity($city);

            $customer->addAdress($address);

            $errors->addAll($this->validator->validate($address));
        }

        if (count($errors) > 0) {
            throw new CrudValidationException($errors);
        }
        $this->getEntityManager()->persist($customer);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $customer;
    }

    public function remove(Customer $entity, bool $flush = false): void
    {
        /**
         * @todo Check if there is any Order associated with the Customer. If so, the Customer can't be deleted.
         */
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQueryFindAll(): Query
    {
        return $this->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC')
                    ->getQuery();
    }

    public function fetchLastRegistered($limit = 10): array
    {
        return $this->createQueryBuilder('c')
                    ->orderBy('c.id', 'DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->execute();
    }
}
