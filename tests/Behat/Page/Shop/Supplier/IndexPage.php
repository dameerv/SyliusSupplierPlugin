<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Page\Shop\Supplier;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(): string
    {
        return 'dameerv_sylius_supplier_plugin_shop_supplier_index';
    }

    /**
     * @inheritdoc
     */
    public function hasPagesNumber(int $pagesNumber): bool
    {
        $vendorsList = $this->getElement('vendors');

        $vendorsNumberOnPage = count($vendorsList->findAll('css', '[data-test-vendor]'));

        return $pagesNumber == $vendorsNumberOnPage;
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'vendors' => '[data-test-vendors]'
        ]);
    }
}
