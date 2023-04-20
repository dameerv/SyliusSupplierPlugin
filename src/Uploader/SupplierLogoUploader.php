<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Uploader;

use Gaufrette\FilesystemInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Symfony\Component\HttpFoundation\File\File;

final class SupplierLogoUploader implements SupplierLogoUploaderInterface
{
    private FilesystemInterface $filesystem;

    public function __construct(
        FilesystemInterface $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    public function upload(SupplierInterface $supplier): void
    {
        if ($supplier->getLogoFile() === null) {
            return;
        }

        /** @var File $file */
        $file = $supplier->getLogoFile();

        if (null !== $supplier->getLogoName() && $this->has($supplier->getLogoName())) {
            $this->remove($supplier->getLogoName());
        }

        do {
            $path = $this->name($file);
        } while ($this->isAdBlockingProne($path) || $this->filesystem->has($path));

        $supplier->setLogoName($path);

        if ($supplier->getLogoName() === null) {
            return;
        }

        if (file_get_contents($file->getPathname()) === false) {
            return;
        }

        $this->filesystem->write(
            $supplier->getLogoName(),
            file_get_contents($file->getPathname()),
            true
        );
    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }

    private function name(File $file): string
    {
        $name = \str_replace('.', '', \uniqid('', true));
        $extension = $file->guessExtension();

        if (\is_string($extension) && '' !== $extension) {
            $name = \sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }

    private function isAdBlockingProne(string $path): bool
    {
        return strpos($path, 'ad') !== false;
    }
}
