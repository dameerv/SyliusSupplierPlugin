<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class SupplierFormMenuBuilderEvent extends MenuBuilderEvent
{
    private SupplierInterface $supplier;

    public function __construct(FactoryInterface $factory, ItemInterface $menu, SupplierInterface $supplier)
    {
        parent::__construct($factory, $menu);

        $this->supplier = $supplier;
    }

    public function getSupplier(): SupplierInterface
    {
        return $this->supplier;
    }
}
