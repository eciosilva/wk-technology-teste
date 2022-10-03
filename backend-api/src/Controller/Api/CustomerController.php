<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Entity\Order;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\CrudValidationException;
use App\Service\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/customer", name="api_customer_")
 * 
 * @author Écio Silva
 */
class CustomerController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    /**
     * @Route("s/{page}", name="index", methods={"GET"}, requirements={"page"="\d+"})
     */
    public function cget(Paginator $paginator, int $page = 1): JsonResponse
    {
        /** @var CustomerRepository */
        $customerRepository  = $this->doctrine->getRepository(Customer::class);
        $pagination = $paginator->paginate($customerRepository->getQueryFindAll(), $page);
        
        return $this->json($pagination);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function get(Customer $customer): JsonResponse
    {
        return $this->json($customer);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $birthdate = \Datetime::createFromFormat('dmY', $data['birthdate']) ?: null;
            $data['birthdate'] = $birthdate;

            $customer = new Customer();

            /** @var CustomerRepository */
            $customerRepository  = $this->doctrine->getRepository(Customer::class);
            $customerRepository->save($customer, $data, true);

            return $this->json($customer);
        } catch (CrudValidationException $ex) {

            return $this->json($ex->getConstraintViolationErrors(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception|\TypeError $e) {

            /** @todo send verbose details about the error */
            return $this->json($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function edit(Customer $customer, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $birthdate = \Datetime::createFromFormat('dmY', str_replace("/", "", $data['birthdate'])) ?: null;
            $data['birthdate'] = $birthdate;

            /** @var CustomerRepository */
            $customerRepository  = $this->doctrine->getRepository(Customer::class);
            $customerRepository->save($customer, $data, true);

            return $this->json($customer);
        } catch (CrudValidationException $ex) {

            return $this->json($ex->getConstraintViolationErrors(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception|\TypeError $e) {
            
            /** @todo send verbose details about the error */
            return $this->json($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Customer $customer): JsonResponse
    {
        /**
         * Checks if the Customer has already had an Order made
         * @var OrderRepository
         */
        $orderRepository = $this->doctrine->getRepository(Order::class);
        $orders = $orderRepository->findBy(['customer'=>$customer]);
        if (null != $orders) {
            return $this->json('Cliente não pode ser excluído: Já existem pedidos em seu nome.', JsonResponse::HTTP_CONFLICT);
        }

        /** @var CustomerRepository */
        $customerRepository  = $this->doctrine->getRepository(Customer::class);
        $customerRepository->remove($customer, true);

        return $this->json(null);
    }

    /**
     * @Route("s/last-registered/{limit}", name="last_registered", methods={"GET"}, requirements={"limit"="\d+"})
     */
    public function lastRegistered($limit=10): JsonResponse
    {
        /** @var CustomerRepository */
        $customerRepository  = $this->doctrine->getRepository(Customer::class);
        $data = $customerRepository->fetchLastRegistered($limit);
        return $this->json($data);
    }

    /**
     * @Route("s/all", name="all", methods={"GET"})
     */
    public function cgetAll(): JsonResponse
    {
        /** @var CustomerRepository */
        $customerRepository  = $this->doctrine->getRepository(Customer::class);
        $data = $customerRepository->findBy([], ['name'=>'ASC']);
        return $this->json($data);
    }
}