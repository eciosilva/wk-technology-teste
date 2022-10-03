<?php

namespace App\Service;

use \Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;

class Paginator
{
    const DEFAULT_ITEMS_PER_PAGE = 10;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * Max listed items per page
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $options;

    /**
     * 
     */
    public function __construct(PaginatorInterface $paginator, ?int $max_items_per_page = null)
    {
        $this->limit = (null === $max_items_per_page) ? self::DEFAULT_ITEMS_PER_PAGE : $max_items_per_page;

        $this->paginator = $paginator;
        $this->options = [];
    }

    /**
     * 
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @param mixed $target
     * @param int
     */
    public function paginate($target, int $page = 1): array
    {
        /*$encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];

        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);*/

        $result = $this->paginator->paginate($target, $page, $this->limit, $this->options);

        return [
            'items' => $result->getItems(),
            'totalItems' => $result->getTotalItemCount(),
            'currentPage'  => $result->getCurrentPageNumber(),
            'totalPages' => (int) ceil($result->getTotalItemCount() / $this->limit)
        ];
    }
}