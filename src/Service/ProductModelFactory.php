<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductLocalePrice;
use Doctrine\ORM\EntityRepository;

class ProductModelFactory
{
    /**
     * @var EntityRepository
     */
    private $localeCurrencyRepository;

    public function __construct(EntityRepository $localeCurrencyRepository)
    {
        $this->localeCurrencyRepository = $localeCurrencyRepository;
    }

    public function getProductModel() : Product
    {
        $product = new Product();
        $localeCurrencies = $this->localeCurrencyRepository->findAll();

        foreach ($localeCurrencies as $localeCurrency )
        {
            $productLocalePrice = new ProductLocalePrice();
            $productLocalePrice->setLocale($localeCurrency);

            $product->addProductLocalePrice($productLocalePrice);
        }

        return $product;
    }
}