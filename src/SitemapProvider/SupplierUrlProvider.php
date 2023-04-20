<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\SitemapProvider;

use Doctrine\Common\Collections\Collection;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierTranslation;
use Dameerv\SyliusSupplierPlugin\Repository\SupplierRepositoryInterface;
use SitemapPlugin\Factory\UrlFactoryInterface;
use SitemapPlugin\Factory\AlternativeUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\UrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

final class SupplierUrlProvider implements UrlProviderInterface
{
    private SupplierRepositoryInterface $supplierRepository;
    private RouterInterface $router;
    private UrlFactoryInterface $sitemapUrlFactory;
    private AlternativeUrlFactoryInterface $urlAlternativeFactory;
    private LocaleContextInterface $localeContext;
    private ChannelInterface $channel;

    public function __construct(
        SupplierRepositoryInterface    $supplierRepository,
        RouterInterface                $router,
        UrlFactoryInterface            $sitemapUrlFactory,
        AlternativeUrlFactoryInterface $urlAlternativeFactory,
        LocaleContextInterface         $localeContext
    ) {
        $this->supplierRepository = $supplierRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->urlAlternativeFactory = $urlAlternativeFactory;
        $this->localeContext = $localeContext;
    }

    public function getName(): string
    {
        return 'suppliers';
    }

    public function generate(ChannelInterface $channel): iterable
    {
        $this->channel = $channel;
        $urls = [];

        foreach ($this->getSuppliers() as $supplier) {
            $urls[] = $this->createSupplierUrl($supplier);
        }

        return $urls;
    }

    /**
     * @psalm-return Collection<array-key, TranslationInterface>
     */
    private function getTranslations(SupplierInterface $supplier): Collection
    {
        return $supplier->getTranslations()->filter(function (TranslationInterface $translation): bool {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes(), true);
    }

    private function getSuppliers(): iterable
    {
        return $this->supplierRepository->findByChannel($this->channel);
    }

    private function getLocaleCodes(): array
    {
        return $this->channel->getLocales()->map(function (LocaleInterface $locale): ?string {
            return $locale->getCode();
        })->toArray();
    }

    private function createSupplierUrl(SupplierInterface $supplier): UrlInterface
    {
        $supplierUrl = $this->sitemapUrlFactory->createNew('');

        $supplierUrl->setChangeFrequency(ChangeFrequency::daily());
        $supplierUrl->setPriority(0.7);

        if (null !== $supplier->getUpdatedAt()) {
            $supplierUrl->setLastModification($supplier->getUpdatedAt());
        } elseif (null !== $supplier->getCreatedAt()) {
            $supplierUrl->setLastModification($supplier->getCreatedAt());
        }

        /** @var SupplierTranslation $translation */
        foreach ($this->getTranslations($supplier) as $translation) {
            if (null === $translation->getLocale() || !$this->localeInLocaleCodes($translation)) {
                continue;
            }

            $location = $this->router->generate('dameerv_sylius_supplier_plugin_shop_supplier_product_index', [
                'slug' => $supplier->getSlug(),
                '_locale' => $translation->getLocale(),
            ]);

            if ($translation->getLocale() === $this->localeContext->getLocaleCode()) {
                $supplierUrl->setLocation($location);

                continue;
            }

            $supplierUrl->addAlternative($this->urlAlternativeFactory->createNew($location, $translation->getLocale()));
        }

        return $supplierUrl;
    }
}
