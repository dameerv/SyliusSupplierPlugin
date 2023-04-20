<?php

declare(strict_types=1);

namespace spec\Dameerv\SyliusSupplierPlugin\Entity;

use Dameerv\SyliusSupplierPlugin\Entity\Supplier;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;

final class SupplierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Supplier::class);
    }

    function it_implements_supplier_interface(): void
    {
        $this->shouldImplement(SupplierInterface::class);
    }

    function it_implements_translatable_interface(): void
    {
        $this->shouldImplement(TranslatableInterface::class);
    }

    function it_implements_toggleable_interface(): void
    {
        $this->shouldImplement(ToggleableInterface::class);
    }

    function it_implements_resource_interface(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_implements_slug_aware_interface(): void
    {
        $this->shouldImplement(SlugAwareInterface::class);
    }

    function it_implements_timestamplable_interface(): void
    {
        $this->shouldImplement(TimestampableInterface::class);
    }

    function it_has_no_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_name_by_default(): void
    {
        $this->getName()->shouldReturn(null);
    }

    function it_is_timestampable(): void
    {
        $dateTime = new \DateTime();
        $this->setCreatedAt($dateTime);
        $this->getCreatedAt()->shouldReturn($dateTime);
        $this->setUpdatedAt($dateTime);
        $this->getUpdatedAt()->shouldReturn($dateTime);
    }

    function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);
        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setName('supplier');
        $this->getName()->shouldReturn('supplier');
        $this->setSlug('supplier');
        $this->getSlug()->shouldReturn('supplier');
        $this->setEmail('supplier@dameerv.com.ar');
        $this->getEmail()->shouldReturn('supplier@dameerv.com.ar');

        $file = new File(__DIR__ . '/supplierSpec.php');
        $this->setLogoFile($file);
        $this->getLogoFile()->shouldReturn($file);

        $this->setLogoName('Dameerv logo');
        $this->getLogoName()->shouldReturn('Dameerv logo');
    }

    function it_associates_channels(ChannelInterface $channel): void
    {
        $this->getChannels()->shouldHaveCount(0);
        $this->addChannel($channel);
        $this->getChannels()->shouldHaveCount(1);
        $this->removeChannel($channel);
        $this->getChannels()->shouldHaveCount(0);
    }

    function it_associates_products(ProductInterface $product): void
    {
        $this->getProducts()->shouldHaveCount(0);
        $this->addProduct($product);
        $this->getProducts()->shouldHaveCount(1);
        $this->removeProduct($product);
        $this->getProducts()->shouldHaveCount(0);
    }
}
