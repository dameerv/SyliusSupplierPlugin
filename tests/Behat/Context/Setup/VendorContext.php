<?php

declare(strict_types=1);

namespace Tests\Dameerv\SyliusSupplierPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Repository\SupplierRepositoryInterface;
use Dameerv\SyliusSupplierPlugin\Uploader\SupplierLogoUploaderInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class VendorContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var FactoryInterface */
    private $vendorFactory;

    /** @var SupplierLogoUploaderInterface */
    private $vendorLogoUploader;

    /** @var SupplierRepositoryInterface */
    private $vendorRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductFactoryInterface */
    private $productFactory;

    public function __construct(
        SharedStorageInterface        $sharedStorage,
        FactoryInterface              $vendorFactory,
        SupplierLogoUploaderInterface $vendorLogoUploader,
        SupplierRepositoryInterface   $vendorRepository,
        ProductRepositoryInterface    $productRepository,
        ProductFactoryInterface       $productFactory
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->vendorFactory = $vendorFactory;
        $this->vendorLogoUploader = $vendorLogoUploader;
        $this->vendorRepository = $vendorRepository;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    /**
     * @param string $name
     * @Given there is an existing vendor with :name name
     */
    public function thereIsAVendorWithName(string $name): void
    {
        $vendor = $this->createVendor($name);

        $this->saveVendor($vendor);
    }

    /**
     * @param int $quantity
     * @Given the store has( also) :quantity vendors
     */
    public function theStoreHasVendors(int $quantity): void
    {
        for ($i = 1;$i <= $quantity;$i++) {
            $this->saveVendor($this->createVendor('Test'.$i));
        }
    }

    /**
     * @Given this vendor has( also) :firstProductName and :secondProductName products associated with it
     */
    public function thisVendorHasProductsAssociatedWithIt(...$productsNames)
    {
        /** @var SupplierInterface $vendor */
        $vendor = $this->vendorRepository->findOneBy([
            'name' => 'Test'
        ]);

        foreach ($productsNames as $productName) {
            /** @var ProductInterface|SupplierAwareInterface $product */
            $product = $this->productFactory->createNew();
            $product->setCode(StringInflector::nameToUppercaseCode($productName));
            $product->setSupplier($vendor);

            $this->productRepository->add($product);
        }
    }

    /**
     * @param string $name
     * @return SupplierInterface
     */
    private function createVendor(string $name): SupplierInterface
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');

        /** @var SupplierInterface $vendor */
        $vendor = $this->vendorFactory->createNew();

        $vendor->setName($name);
        $vendor->setSlug(strtolower($name));
        $vendor->setEmail(strtolower($name).'@dameerv.com.ar');
        $vendor->setCurrentLocale('en_US');
        $vendor->setFallbackLocale('en_US');
        $vendor->setDescription('This is a test');

        $vendor->addChannel($channel);

        $uploadedFile = new UploadedFile(__DIR__.'/../../Resources/images/logo_dameerv.png', 'logo_dameerv.png');
        $vendor->setLogoFile($uploadedFile);

        $this->vendorLogoUploader->upload($vendor);

        return $vendor;
    }

    /**
     * @param SupplierInterface $vendor
     */
    private function saveVendor(SupplierInterface $vendor): void
    {
        $this->vendorRepository->add($vendor);
    }
}
