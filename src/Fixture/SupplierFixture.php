<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class SupplierFixture extends AbstractResourceFixture
{
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $node = $resourceNode->children();

        $node->arrayNode('channels')->scalarPrototype();
        $node->scalarNode('name')->cannotBeEmpty();
        $node->scalarNode('slug')->cannotBeEmpty();
        $node->scalarNode('email')->cannotBeEmpty();
        $node->scalarNode('logo');
        $node->scalarNode('description');
    }

    public function getName(): string
    {
        return 'supplier';
    }
}
