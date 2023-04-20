<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Page\Shop\Supplier;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(): string
    {
        return 'dameerv_sylius_supplier_plugin_shop_supplier_product_index';
    }

    /**
     * @inheritdoc
     */
    public function hasName(string $name): bool
    {
        return $name === $this->getElement('name')->getText();
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '[data-test-supplier-name]'
        ]);
    }
}
