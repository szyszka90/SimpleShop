<?php

namespace App\Domain;

interface ProductInterface
{
    public function getName(): ?string;

    public function getDescription(): ?string;

    public function getPrice(): ?float;

    public function getCurrency(): ?string;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCurrency(string $currency);
}