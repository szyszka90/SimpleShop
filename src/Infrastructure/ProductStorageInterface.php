<?php

namespace App\Infrastructure;

use App\Domain\ProductInterface;

interface ProductStorageInterface
{
    public function addProduct(ProductInterface $product);
}