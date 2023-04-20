<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class VendorContext implements Context
{
    /** @var RepositoryInterface */
    private $vendorRepository;

    public function __construct(
        RepositoryInterface $vendorRepository
    ) {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * @Transform /^vendor "([^"]+)"$/
     * @Transform /^"([^"]+)" vendor$/
     * @param string $vendorName
     * @return SupplierInterface
     */
    public function getVendorByName(string $vendorName): SupplierInterface
    {
        /** @var SupplierInterface $vendor */
        $vendor = $this->vendorRepository->findOneBy(['name' => $vendorName]);

        Assert::notNull(
            $vendor,
            'Vendor with name %s does not exist'
        );

        return $vendor;
    }
}
