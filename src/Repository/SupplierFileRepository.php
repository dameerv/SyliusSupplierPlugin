<?php

namespace Dameerv\SyliusSupplierPlugin\Repository;

use App\Entity\Supplier\SupplierFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepositoryTrait;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @extends ServiceEntityRepository<SupplierFile>
 *
 * @method SupplierFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupplierFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupplierFile[]    findAll()
 * @method SupplierFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierFileRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use ResourceRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplierFile::class);
    }
}
