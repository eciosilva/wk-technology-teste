<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Service\CrudValidationException;
use App\Service\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/api/order", name="api_order_")
 * 
 * @author Écio Silva
 */
class OrderController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    /**
     * @Route("s/{page}", name="index", methods={"GET"}, requirements={"page"="\d+"})
     */
    public function cget(Paginator $paginator, int $page = 1): JsonResponse
    {
        /** @var OrderRepository */
        $procutRepository  = $this->doctrine->getRepository(Order::class);
        $pagination = $paginator->paginate($procutRepository->getQueryFindAll(), $page);
        
        return $this->json($pagination);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function get(Order $order): JsonResponse
    {
        return $this->json($order);
    }

    /**
     * @Route("/{id}/products", name="products", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function products(Order $order): JsonResponse
    {
        /** @var OrderProductRepository */
        $orderProductRepository = $this->doctrine->getRepository(OrderProduct::class);
        $data = $orderProductRepository->findBy(['order'=>$order]);
        
        return $this->json($data);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $order = new Order();

            /** @var OrderRepository */
            $orderRepository  = $this->doctrine->getRepository(Order::class);
            $orderRepository->save($order, $data, true);

            return $this->json($order);
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
    public function edit(Order $order, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            /** @var OrderRepository */
            $orderRepository  = $this->doctrine->getRepository(Order::class);
            $orderRepository->save($order, $data, true);

            return $this->json($order);
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
    public function delete(Order $order): JsonResponse
    {
        /** @var OrderRepository */
        $orderRepository  = $this->doctrine->getRepository(Order::class);
        $orderRepository->remove($order, true);

        return $this->json(null);
    }

    /**
     * @Route("s/last-registered/{limit}", name="last_registered", methods={"GET"}, requirements={"limit"="\d+"})
     */
    public function lastRegistered($limit=10): JsonResponse
    {
        /** @var OrderRepository */
        $orderRepository  = $this->doctrine->getRepository(Order::class);
        $data = $orderRepository->findBy([], ["createdAt"=>"DESC"], $limit);
        return $this->json($data);
    }
}