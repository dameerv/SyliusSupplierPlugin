<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Page\Shop\Supplier;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @param int $pagesNumber
     * @return bool
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasPagesNumber(int $pagesNumber): bool;
}
