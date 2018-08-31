<?php

namespace App\Application\Command;

use App\Infrastructure\ProductStorageInterface;
use App\Service\LocaleInformation;
use App\Service\MessageFactory;

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
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $adminMail;

    public function __construct(ProductStorageInterface $productStorage, LocaleInformation $localeInformation, MessageFactory $messageFactory, \Swift_Mailer $mailer, string $adminMail)
    {
        $this->productStorage = $productStorage;
        $this->localeInformation = $localeInformation;
        $this->messageFactory = $messageFactory;
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
    }
    public function handle(AddNewProductCommand $command)
    {
        $product = $command->getProduct();

        $currency = $this->localeInformation->getLocaleInformation(LocaleInformation::INTERNATIONAL_CURRENCY_SYMBOL);
        $product->setCurrency($currency);

        $this->productStorage->addProduct($product);

        $message = $this->messageFactory->getMessage($this->adminMail, 'Produkt został dodany', 'emails/add_product.html.twig',
            [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'currency' => $product->getCurrency()
            ]
        );

        $this->mailer->send($message);
    }
}