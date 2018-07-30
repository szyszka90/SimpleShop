<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductLocalePrice", mappedBy="product", orphanRemoval=true)
     */
    private $productLocalePrices;

    public function __construct()
    {
        $this->productLocalePrices = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ProductLocalePrice[]
     */
    public function getProductLocalePrices(): Collection
    {
        return $this->productLocalePrices;
    }

    public function addProductLocalePrice(ProductLocalePrice $productLocalePrice): self
    {
        if (!$this->productLocalePrices->contains($productLocalePrice)) {
            $this->productLocalePrices[] = $productLocalePrice;
            $productLocalePrice->setProduct($this);
        }

        return $this;
    }

    public function removeProductLocalePrice(ProductLocalePrice $productLocalePrice): self
    {
        if ($this->productLocalePrices->contains($productLocalePrice)) {
            $this->productLocalePrices->removeElement($productLocalePrice);
            // set the owning side to null (unless already changed)
            if ($productLocalePrice->getProduct() === $this) {
                $productLocalePrice->setProduct(null);
            }
        }

        return $this;
    }
}
