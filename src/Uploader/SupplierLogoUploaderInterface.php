<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Uploader;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;

interface SupplierLogoUploaderInterface
{
    public function upload(SupplierInterface $supplier): void;

    public function remove(string $path): bool;
}
