<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Component\Core\Model\ChannelInterface;

trait ProductRepositoryTrait
{
    abstract public function createQueryBuilder($alias, $indexBy = null);

    public function createShopListBySupplierQueryBuilder(
        ChannelInterface  $channel,
        SupplierInterface $supplier,
        string            $locale,
        array             $sorting = []
    ): QueryBuilder {
        $queryBuilder = $this->createQueryBuilder('o')
            ->distinct()
            ->addSelect('translation')
            ->addSelect('productTaxon')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->innerJoin('o.productTaxons', 'productTaxon');

        $queryBuilder
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('o.enabled = true')
            ->andWhere('o.supplier = :supplier')
            ->setParameter('locale', $locale)
            ->setParameter('channel', $channel)
            ->setParameter('supplier', $supplier)
        ;

        if (isset($sorting['price'])) {
            $subQuery = $this->createQueryBuilder('m')
                ->select('min(v.position)')
                ->innerJoin('m.variants', 'v')
                ->andWhere('m.id = :product_id')
                ->andWhere('v.enabled = :enabled')
            ;

            $queryBuilder
                ->addSelect('variant')
                ->addSelect('channelPricing')
                ->innerJoin('o.variants', 'variant')
                ->innerJoin('variant.channelPricings', 'channelPricing')
                ->andWhere('channelPricing.channelCode = :channelCode')
                ->andWhere(
                    $queryBuilder->expr()->in(
                        'variant.position',
                        str_replace(':product_id', 'o.id', $subQuery->getDQL())
                    )
                )
                ->setParameter('channelCode', $channel->getCode())
                ->setParameter('enabled', true)
            ;
        }

        return $queryBuilder;
    }
}
