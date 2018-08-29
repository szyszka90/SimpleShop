<?php

namespace App\Application\Query;

use App\Repository\ProductRepository;

class DoctrineProductsQuery implements ProductsQueryInterface
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAllOrderedByCreatedAt()
    {
        return $this->repository->findAllOrderedByCreatedAt();
    }
}