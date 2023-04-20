<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

interface SupplierAwareInterface
{
    public function getSupplier(): ?SupplierInterface;

    public function setSupplier(?SupplierInterface $supplier): void;
}
