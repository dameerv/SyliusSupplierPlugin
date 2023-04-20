<?php

declare(strict_types=1);

namespace spec\Dameerv\SyliusSupplierPlugin\Mapping;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Dameerv\SyliusSupplierPlugin\Entity\Supplier;
use Dameerv\SyliusSupplierPlugin\Mapping\SupplierAwareListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Resource\Metadata\RegistryInterface;

final class SupplierAwareListenerSpec extends ObjectBehavior
{
    public function let(
        RegistryInterface $resourceMetadataRegistry
    ): void
    {
        $this->beConstructedWith(
            $resourceMetadataRegistry,
            Supplier::class,
            Product::class,
            Channel::class
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SupplierAwareListener::class);
    }

    function it_implements_event_subscriber(): void
    {
        $this->shouldImplement(EventSubscriber::class);
    }

    function it_does_not_map_supplier_if_not_class_metadata(
        LoadClassMetadataEventArgs $eventArgs,
        \ReflectionClass $reflection
    ): void {
        $eventArgs->getClassMetadata()->willReturn(Argument::any());

        $reflection->implementsInterface(Argument::any())->shouldNotBeCalled();
    }

    function it_does_not_map_supplier_if_not_reflection_abstract(
        \ReflectionClass $reflection
    ): void {
        $reflection->isAbstract()->willReturn(false);

        $reflection->implementsInterface(Argument::any())->shouldNotBeCalled();
    }
}
