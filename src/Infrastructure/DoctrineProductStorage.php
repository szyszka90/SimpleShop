<?php

namespace App\Infrastructure;

use App\Domain\ProductInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductStorage implements ProductStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addProduct(ProductInterface $product)
    {
        $this->em->persist($product);
        $this->em->flush();
    }
}