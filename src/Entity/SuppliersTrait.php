<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait SuppliersTrait
{
    protected Collection $suppliers;

    public function __construct()
    {
        $this->suppliers = new ArrayCollection();
    }

    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function hasSupplier(SupplierInterface $supplier): bool
    {
        return $this->suppliers->contains($supplier);
    }

    public function addSupplier(SupplierInterface $supplier): void
    {
        if (!$this->hasSupplier($supplier)) {
            $this->suppliers->add($supplier);
        }
    }

    public function removeSupplier(SupplierInterface $supplier): void
    {
        if ($this->hasSupplier($supplier)) {
            $this->suppliers->removeElement($supplier);
        }
    }
}
