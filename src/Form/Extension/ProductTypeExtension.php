<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Form\Extension;

use Dameerv\SyliusSupplierPlugin\Form\Type\SupplierChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('supplier', SupplierChoiceType::class, [
            'label' => 'dameerv_sylius_supplier_plugin.form.product.select_supplier',
            'multiple' => true,
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
