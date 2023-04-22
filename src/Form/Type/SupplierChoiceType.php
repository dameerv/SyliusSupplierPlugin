<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Form\Type;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Dameerv\SyliusSupplierPlugin\Repository\SupplierRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SupplierChoiceType extends AbstractType
{
    private SupplierRepositoryInterface $supplierRepository;

    public function __construct(
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var bool $multiple */
        $multiple = $options['multiple'];
        if ($multiple) {
            $builder->addModelTransformer(new CollectionToArrayTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $criteria = [];
        $orderBy = ['name' => 'ASC'];

        $resolver->setDefaults([
            'choices' => function (Options $_options) use ($criteria, $orderBy): array {
                $suppliers = $this->supplierRepository->findBy($criteria, $orderBy);
                $choices = [];
                /** @var SupplierInterface $supplier */
                foreach ($suppliers as $supplier) {
                    $choices[$supplier->getName()] = $supplier;
                }
                return $choices;
            },
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'dameerv_sylius_supplier_choice';
    }
}
