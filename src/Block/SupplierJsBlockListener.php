<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Block;

use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;

final class SupplierJsBlockListener
{
    public function onBlockEvent(BlockEvent $event): void
    {
        $template = '@DameervSyliusSupplierPlugin/Admin/Supplier/_supplier_js.html.twig';

        $block = new Block();
        $block->setId(uniqid('', true));
        $block->setSettings(array_replace($event->getSettings(), [
            'template' => $template,
        ])
        );
        $block->setType('sonata.block.service.template');

        $event->addBlock($block);
    }
}
