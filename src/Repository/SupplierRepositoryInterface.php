<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    public function createShopListQueryBuilder(
        ChannelInterface $channel,
        array $sorting = []
    ): QueryBuilder;

    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder;

    public function findByChannel(ChannelInterface $channel): array;

    public function findOneBySlug(string $slug, string $locale): ?SupplierInterface;
}
