<?php

namespace App\Application\Command;

use App\Domain\ProductInterface;

class AddNewProductCommand
{
    /**
     * @var ProductInterface
     */
    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

}