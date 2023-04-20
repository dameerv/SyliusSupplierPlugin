<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;

interface IndexPageInterface extends BaseIndexPageInterface
{
    /**
     * @param string $name
     */
    public function deleteVendor(string $name): void;
}
