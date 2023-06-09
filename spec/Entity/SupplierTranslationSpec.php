<?php

declare(strict_types=1);

namespace spec\Dameerv\SyliusSupplierPlugin\Entity;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierTranslation;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class SupplierTranslationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SupplierTranslation::class);
    }

    function it_extends_abstract_translation()
    {
        $this->shouldHaveType(AbstractTranslation::class);
    }

    function it_implements_translation_interface(): void
    {
        $this->shouldImplement(TranslationInterface::class);
    }

    function it_implements_vendor_translation_interface(): void
    {
        $this->shouldImplement(SupplierTranslationInterface::class);
    }

    function it_implements_resource_interface(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_no_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_description_by_default(): void
    {
        $this->getDescription()->shouldReturn(null);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setDescription('Vendor description');
        $this->getDescription()->shouldReturn('Vendor description');;
    }
}
