<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $item */
        $item = $menu->getChild('catalog');
        if (null == $item) {
            $item = $menu;
        }

        $item->addChild('dameerv_sylius_supplier_plugin.menu.admin.suppliers',
            ['route' => 'dameerv_sylius_supplier_plugin_admin_supplier_index']
        )
            ->setLabel('dameerv_sylius_supplier_plugin.menu.admin.suppliers')
            ->setLabelAttribute('icon', 'handshake');
    }
}
