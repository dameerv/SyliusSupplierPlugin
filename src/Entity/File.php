<?php

namespace Dameerv\SyliusSupplierPlugin\Entity;

use SplFileInfo;
use Symfony\Component\Mime\MimeTypes;

abstract class File implements FileInterface
{
    /** @var mixed */
    protected $id;

    /** @var null|string */
    protected $type;

    /** @var null|string */
    protected $mimeType;

    /** @var SplFileInfo */
    protected $file;

    /** @var string */
    protected $path;

    /** @var object */
    protected $owner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile(): ?SplFileInfo
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function setFile(?SplFileInfo $file): void
    {
        $this->file = $file;

        if (null !== $file) {
            $this->mimeType = (new MimeTypes())->guessMimeType($file->getRealPath());
        } else {
            $this->mimeType = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile(): bool
    {
        return null !== $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPath(): bool
    {
        return null !== $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }
}
