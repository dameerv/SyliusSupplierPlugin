<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\EventListener;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Uploader\SupplierLogoUploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class SupplierLogoUploadListener
{
    private SupplierLogoUploaderInterface $uploader;

    public function __construct(SupplierLogoUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadLogo(GenericEvent $event): void
    {
        $supplier = $event->getSubject();
        Assert::isInstanceOf($supplier, SupplierInterface::class);

        $this->uploader->upload($supplier);
    }
}
