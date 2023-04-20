## Customization

### Overriding models and resources

The plugin configures the model like a "sylius resource" using the `sylius_resource` configuration.
You can see it here: [src/Resources/config/resources/supplier.yaml](https://github.com/dameerv/SyliusSupplierPlugin/blob/master/src/Resources/config/resources/supplier.yaml).

So, you can override the class resource you want simply overriding the proper part of that configuration.
