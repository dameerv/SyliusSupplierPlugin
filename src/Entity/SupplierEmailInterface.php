<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface SupplierEmailInterface extends
    ResourceInterface,
    SupplierAwareInterface,
    TimestampableInterface
{
    public function getValue(): ?string;

    public function setValue(?string $value): void;
}
