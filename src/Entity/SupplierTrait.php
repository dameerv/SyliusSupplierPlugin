<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

trait SupplierTrait
{
    protected ?SupplierInterface $supplier = null;

    public function getSupplier(): ?SupplierInterface
    {
        return $this->supplier;
    }

    public function setSupplier(?SupplierInterface $supplier): void
    {
        $this->supplier = $supplier;
    }
}
