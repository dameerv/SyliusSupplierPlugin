<?php

namespace Dameerv\SyliusSupplierPlugin\Entity;

use App\Repository\SupplierFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierFileRepository::class)]
#[ORM\Table(name: 'app_supplier_file')]
class SupplierFile extends File
{

}
