<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Fixture\Factory;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ProductExampleFactory as BaseProductExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Product\Generator\ProductVariantGeneratorInterface;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductExampleFactory extends BaseProductExampleFactory
{
    protected RepositoryInterface $supplierRepository;
    protected OptionsResolver $optionsResolver;

    public function __construct(
        RepositoryInterface              $supplierRepository,
        FactoryInterface                 $productFactory,
        FactoryInterface                 $productVariantFactory,
        FactoryInterface                 $channelPricing,
        ProductVariantGeneratorInterface $variantGenerator,
        FactoryInterface                 $productAttributeValueFactory,
        FactoryInterface                 $productImageFactory,
        FactoryInterface                 $productTaxonFactory,
        ImageUploaderInterface           $imageUploader,
        SlugGeneratorInterface           $slugGenerator,
        RepositoryInterface              $taxonRepository,
        RepositoryInterface              $productAttributeRepository,
        RepositoryInterface              $productOptionRepository,
        RepositoryInterface              $channelRepository,
        RepositoryInterface              $localeRepository,
        RepositoryInterface              $taxCategoryRepository,
        ?FileLocatorInterface            $fileLocator = null
    ) {
        $this->supplierRepository = $supplierRepository;

        $this->optionsResolver = new OptionsResolver();

        parent::__construct(
            $productFactory,
            $productVariantFactory,
            $channelPricing,
            $variantGenerator,
            $productAttributeValueFactory,
            $productImageFactory,
            $productTaxonFactory,
            $imageUploader,
            $slugGenerator,
            $taxonRepository,
            $productAttributeRepository,
            $productOptionRepository,
            $channelRepository,
            $localeRepository,
            $taxCategoryRepository,
            $fileLocator
        );
    }

    public function create(array $options = []): ProductInterface
    {
        $product = parent::create($options);

        $this->configureOptions($this->optionsResolver);

        $options = $this->optionsResolver->resolve($options);

        if ($product instanceof SupplierAwareInterface) {
            $product->setSupplier($options['supplier']);
        }

        return $product;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefault('supplier', LazyOption::randomOne($this->supplierRepository))
            ->setAllowedTypes('supplier', ['string', SupplierInterface::class])
            ->setNormalizer('supplier', LazyOption::findOneBy($this->supplierRepository, 'slug'))
        ;
    }
}
