<?php

namespace App\Application\Command;

use App\Infrastructure\ProductStorageInterface;
use App\Service\LocaleInformation;

class AddNewProductHandler
{
    /**
     * @var ProductStorageInterface
     */
    private $productStorage;

    /**
     * @var LocaleInformation
     */
    private $localeInformation;

    public function __construct(ProductStorageInterface $productStorage, LocaleInformation $localeInformation)
    {
        $this->productStorage = $productStorage;
        $this->localeInformation = $localeInformation;
    }
    public function handle(AddNewProductCommand $command)
    {
        $product = $command->getProduct();

        $currency = $this->localeInformation->getLocaleInformation(LocaleInformation::INTERNATIONAL_CURRENCY_SYMBOL);
        $product->setCurrency($currency);

        $this->productStorage->addProduct($product);
    }
}