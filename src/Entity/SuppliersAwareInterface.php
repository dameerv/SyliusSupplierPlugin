<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface SuppliersAwareInterface
{
    public function getSuppliers(): Collection;

    public function hasSupplier(SupplierInterface $supplier): bool;

    public function addSupplier(SupplierInterface $supplier): void;

    public function removeSupplier(SupplierInterface $supplier): void;
}
