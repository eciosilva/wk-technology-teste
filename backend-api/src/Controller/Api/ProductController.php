<?php

namespace App\Controller\Api;

use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Repository\OrderProductRepository;
use App\Repository\ProductRepository;
use App\Service\CrudValidationException;
use App\Service\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/api/product", name="api_product_")
 * 
 * @author Écio Silva
 */
class ProductController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    /**
     * @Route("s/{page}", name="index", methods={"GET"}, requirements={"page"="\d+"})
     */
    public function cget(Paginator $paginator, int $page = 1): JsonResponse
    {
        /** @var ProductRepository */
        $procutRepository  = $this->doctrine->getRepository(Product::class);
        $pagination = $paginator->paginate($procutRepository->getQueryFindAll(), $page);
        
        return $this->json($pagination);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function get(Product $product): JsonResponse
    {
        return $this->json($product);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $product = new Product();

            /** @var ProductRepository */
            $productRepository  = $this->doctrine->getRepository(Product::class);
            $productRepository->save($product, $data, true);

            return $this->json($product);
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
    public function edit(Product $product, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            /** @var ProductRepository */
            $productRepository  = $this->doctrine->getRepository(Product::class);
            $productRepository->save($product, $data, true);

            return $this->json($product);
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
    public function delete(Product $product): JsonResponse
    {
        /**
         * Checks if the Product has already been purchased
         * @var OrderProductRepository
         */
        $orderProductRepository = $this->doctrine->getRepository(OrderProduct::class);
        $orderProducts = $orderProductRepository->findBy(['product'=>$product]);
        if (null != $orderProducts) {
            return $this->json('Produto não pode ser excluído: Já existem pedidos com ele.', JsonResponse::HTTP_CONFLICT);
        }

        /** @var ProductRepository */
        $productRepository  = $this->doctrine->getRepository(Product::class);
        $productRepository->remove($product, true);

        return $this->json(null);
    }

    /**
     * @Route("s/all", name="all", methods={"GET"})
     */
    public function cgetAll(): JsonResponse
    {
        /** @var ProductRepository */
        $productRepository  = $this->doctrine->getRepository(Product::class);
        $data = $productRepository->findBy([], ['name'=>'ASC']);
        return $this->json($data);
    }
}