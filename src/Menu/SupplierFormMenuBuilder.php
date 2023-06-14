<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Event\SupplierFormMenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SupplierFormMenuBuilder
{
    private FactoryInterface $factory;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!array_key_exists('supplier', $options) || !$options['supplier'] instanceof SupplierInterface) {
            return $menu;
        }

        $menu
            ->addChild('details')
            ->setAttribute('template', '@DameervSyliusSupplierPlugin/Admin/Supplier/Tab/_details.html.twig')
            ->setLabel('sylius.ui.details')
            ->setCurrent(true);

        $menu
            ->addChild('profile')
            ->setAttribute('template', '@DameervSyliusSupplierPlugin/Admin/Supplier/Tab/_profile.html.twig')
            ->setLabel('dameerv_sylius_supplier_plugin.ui.profile');

        $menu
            ->addChild('media')
            ->setAttribute('template', '@DameervSyliusSupplierPlugin/Admin/Supplier/Tab/_media.html.twig')
            ->setLabel('sylius.ui.media');

        $this->eventDispatcher->dispatch(
            new SupplierFormMenuBuilderEvent($this->factory, $menu, $options['supplier'])
        );

        return $menu;
    }
}
