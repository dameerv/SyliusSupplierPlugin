<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

final class SupplierEmailType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('value', EmailType::class, [
                'label' => 'sylius.ui.value',
            ]);
    }
}
