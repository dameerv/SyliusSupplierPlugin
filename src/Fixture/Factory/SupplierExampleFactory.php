<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Fixture\Factory;

use Faker\Factory;
use Faker\Generator as FakerGenerator;
use Generator;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Uploader\SupplierLogoUploaderInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierExampleFactory implements ExampleFactoryInterface
{
    protected FactoryInterface $supplierFactory;
    protected SupplierLogoUploaderInterface $supplierLogoUploader;
    protected RepositoryInterface $channelRepository;
    protected RepositoryInterface $localeRepository;
    protected FakerGenerator $faker;
    protected ?FileLocatorInterface $fileLocator;
    protected OptionsResolver $optionsResolver;

    public function __construct(
        FactoryInterface              $supplierFactory,
        SupplierLogoUploaderInterface $SupplierLogoUploader,
        RepositoryInterface           $channelRepository,
        RepositoryInterface           $localeRepository,
        ?FileLocatorInterface         $fileLocator = null
    ) {
        $this->supplierFactory = $supplierFactory;
        $this->supplierLogoUploader = $SupplierLogoUploader;
        $this->channelRepository = $channelRepository;
        $this->localeRepository = $localeRepository;
        $this->fileLocator = $fileLocator;

        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): SupplierInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var SupplierInterface $supplier */
        $supplier = $this->supplierFactory->createNew();
        $supplier->setName($options['name']);
        $supplier->setEmail($options['email']);

        /** @var string $localeCode */
        foreach ($this->getLocales() as $localeCode) {
            $supplier->setCurrentLocale($localeCode);
            $supplier->setFallbackLocale($localeCode);

            $supplier->setDescription($options['description']);
            $supplier->setSlug($options['slug']);
        }

        foreach ($options['channels'] as $channel) {
            $supplier->addChannel($channel);
        }

        $supplier->setLogoFile($this->createImage($options['logo']));

        $this->supplierLogoUploader->upload($supplier);

        return $supplier;
    }

    protected function createImage(string $imagePath): UploadedFile
    {
        /** @var string $imagePath */
        $imagePath = null === $this->fileLocator ? $imagePath : $this->fileLocator->locate($imagePath);

        return new UploadedFile($imagePath, basename($imagePath));
    }

    protected function getLocales(): Generator
    {
        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            yield $locale->getCode();
        }
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('channels', LazyOption::randomOnes($this->channelRepository, 3))
            ->setAllowedTypes('channels', 'array')
            ->setNormalizer('channels', LazyOption::findBy($this->channelRepository, 'code'))
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setDefault('name', function (Options $_options): string {
                return $this->faker->company();
            })
            ->setRequired('slug')
            ->setAllowedTypes('slug', 'string')
            ->setDefault('slug', function (Options $options): string {
                return StringInflector::nameToCode((string) $options['name']);
            })
            ->setRequired('email')
            ->setAllowedTypes('email', 'string')
            ->setDefault('email', function (Options $_options): string {
                return $this->faker->companyEmail();
            })
            ->setRequired('logo')
            ->setAllowedTypes('logo', 'string')
            ->setDefault('logo', function (Options $_options): string {
                return __DIR__ . '/../../Resources/fixtures/supplier/images/0' . rand(1, 3) . '.png';
            })
            ->setRequired('description')
            ->setAllowedTypes('description', 'string')
            ->setDefault('description', function (Options $_options): string {
                return $this->faker->text();
            })
        ;
    }
}
