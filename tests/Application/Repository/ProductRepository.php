<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Application\Repository;

use Dameerv\SyliusSupplierPlugin\Repository\ProductRepositoryInterface;
use Dameerv\SyliusSupplierPlugin\Repository\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
}
