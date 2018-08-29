<?php

namespace App\Application\Query;

interface ProductsQueryInterface
{
    public function getAllOrderedByCreatedAt();
}