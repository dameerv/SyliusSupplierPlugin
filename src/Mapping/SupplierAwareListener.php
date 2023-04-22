<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Mapping;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SuppliersAwareInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Dameerv\SyliusSupplierPlugin\Entity\Channel;
use Dameerv\SyliusSupplierPlugin\Entity\Product;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;

final class SupplierAwareListener implements EventSubscriber
{
    private RegistryInterface $resourceMetadataRegistry;
    private string $supplierClass;
    private string $productClass;
    private string $channelClass;

    public function __construct(
        RegistryInterface $resourceMetadataRegistry,
        string            $supplierClass,
        string            $productClass,
        string            $channelClass
    ) {
        $this->resourceMetadataRegistry = $resourceMetadataRegistry;
        $this->supplierClass = $supplierClass;
        $this->productClass = $productClass;
        $this->channelClass = $channelClass;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $reflection = $classMetadata->reflClass;

        /**
         * @phpstan-ignore-next-line
         */
        if ($reflection === null || $reflection->isAbstract()) {
            return;
        }

        if (
            $reflection->implementsInterface(ProductInterface::class) &&
            $reflection->implementsInterface(SupplierAwareInterface::class)
        ) {
            $this->mapSupplierAware($classMetadata, 'supplier_id', 'products');
        }

        if (
            $reflection->implementsInterface(ChannelInterface::class) &&
            $reflection->implementsInterface(SuppliersAwareInterface::class)
        ) {
            $this->mapSuppliersAware($classMetadata, 'channel_id', 'channels');
        }

        if (
            $reflection->implementsInterface(SupplierInterface::class) &&
            !$classMetadata->isMappedSuperclass
        ) {
            $this->mapSupplier($classMetadata);
        }
    }

    private function mapSupplierAware(ClassMetadata $metadata, string $joinColumn, string $inversedBy): void
    {
        try {
            $supplierMetadata = $this->resourceMetadataRegistry->getByClass($this->supplierClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('suppliers')) {
            $metadata->mapManyToOne([
                'fieldName' => 'suppliers',
                'targetEntity' => $supplierMetadata->getClass('model'),
                'inversedBy' => $inversedBy,
                'joinColumns' => [
                    [
                        'name' => $joinColumn,
                        'referencedColumnName' => 'id',
                        'nullable' => false
                    ]
                ]
            ]);
        }
    }

    private function mapSuppliersAware(ClassMetadata $metadata, string $joinColumn, string $inversedBy): void
    {
        try {
            $supplierMetadata = $this->resourceMetadataRegistry->getByClass($this->supplierClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('suppliers')) {
            $metadata->mapManyToMany([
                'fieldName' => 'suppliers',
                'targetEntity' => $supplierMetadata->getClass('model'),
                'inversedBy' => $inversedBy,
                'joinTable' => [
                    'name' => 'dameerv_supplier_' . $inversedBy,
                    'joinColumns' => [
                        [
                            'name' => $joinColumn,
                            'referencedColumnName' => 'id'
                        ]
                    ],
                    'inverseJoinColumns' => [
                        [
                            'name' => 'supplier_id',
                            'referencedColumnName' => 'id'
                        ]
                    ],
                ]
            ]);
        }
    }

    private function mapSupplier(ClassMetadata $metadata): void
    {
        try {
            $productMetadata = $this->resourceMetadataRegistry->getByClass($this->productClass);
            $channelMetadata = $this->resourceMetadataRegistry->getByClass($this->channelClass);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$metadata->hasAssociation('products')) {
            $productConfig = [
                'fieldName' => 'products',
                'targetEntity' => $productMetadata->getClass('model')
            ];

            if (Product::class != $this->productClass) {
                $productConfig = array_merge($productConfig, [
                    'mappedBy' => 'suppliers',
                ]);
            }

            $metadata->mapOneToMany($productConfig);
        }

        if (!$metadata->hasAssociation('channels')) {
            $channelConfig = [
                'fieldName' => 'channels',
                'targetEntity' => $channelMetadata->getClass('model')
            ];

            if (Channel::class != $this->channelClass) {
                $channelConfig = array_merge($channelConfig, [
                    'mappedBy' => 'suppliers',
                ]);
            }

            $metadata->mapManyToMany($channelConfig);
        }
    }
}
