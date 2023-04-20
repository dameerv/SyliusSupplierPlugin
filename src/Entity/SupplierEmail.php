<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

use Sylius\Component\Resource\Model\TimestampableTrait;

class SupplierEmail implements SupplierEmailInterface
{
    use SupplierTrait;
    use TimestampableTrait;

    protected ?int $id = null;
    protected ?string $value = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }
}
