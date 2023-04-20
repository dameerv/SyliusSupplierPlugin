<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dameerv_sylius_supplier_plugin');

        $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
