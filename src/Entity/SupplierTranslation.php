<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\TimestampableTrait;

class SupplierTranslation extends AbstractTranslation implements SupplierTranslationInterface
{
    use TimestampableTrait;

    protected ?int $id = null;
    protected ?string $description = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
