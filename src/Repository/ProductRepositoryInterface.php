<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function createShopListBySupplierQueryBuilder(
        ChannelInterface  $channel,
        SupplierInterface $supplier,
        string            $locale,
        array             $sorting = []
    ): QueryBuilder;
}
