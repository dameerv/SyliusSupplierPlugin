<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Form\Type;

use Dameerv\SyliusSupplierPlugin\Entity\SupplierInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SupplierType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.slug',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => SupplierTranslationType::class,
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.translations',
            ])
            ->add('email', EmailType::class, [
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.email',
            ])
            ->add('logoFile', FileType::class, [
                 'label' => 'dameerv_sylius_supplier_plugin.form.supplier.logo',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.channels',
            ])
            ->add('extraEmails', CollectionType::class, [
                'label' => 'dameerv_sylius_supplier_plugin.form.supplier.extra_emails',
                'entry_type' => SupplierEmailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form): array {
                /** @var SupplierInterface|null $supplier */
                $supplier = $form->getData();

                if (!$supplier instanceof SupplierInterface || null === $supplier->getId()) {
                    return array_merge($this->validationGroups, ['dameerv_logo_create']);
                }

                return $this->validationGroups;
            },
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'dameerv_supplier';
    }
}
