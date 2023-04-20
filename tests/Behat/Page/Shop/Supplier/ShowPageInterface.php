<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Page\Shop\Supplier;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    /**
     * @param string $name
     * @return bool
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasName(string $name): bool;
}
