<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Form\Type;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class SupplierTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('description', CKEditorType::class, [
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.description',
            ])
        ;
    }
}
