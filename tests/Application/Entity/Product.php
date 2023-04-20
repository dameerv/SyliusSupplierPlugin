<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Table(name="sylius_product")
 * @ORM\Entity
 */
class Product extends BaseProduct implements SupplierAwareInterface
{
    use SupplierTrait;
}
