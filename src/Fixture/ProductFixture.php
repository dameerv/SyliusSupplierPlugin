<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\ProductFixture as BaseProductFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ProductFixture extends BaseProductFixture
{
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $node = $resourceNode->children();

        $node->scalarNode('supplier');

        parent::configureResourceNode($resourceNode);
    }
}
