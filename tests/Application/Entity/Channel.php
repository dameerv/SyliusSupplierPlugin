<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dameerv\SyliusSupplierPlugin\Entity\SuppliersAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SuppliersTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity
 */
class Channel extends BaseChannel implements SuppliersAwareInterface
{
    use SuppliersTrait {
        __construct as private initializeVendorsCollection;
    }

    public function __construct()
    {
        parent::__construct();

        $this->initializeVendorsCollection();
    }
}
