## Usage

For the administration you will have the Supplier menu.
Feel free to modify the plugin templates like you want.

### Partial routes

To render supplier by channel you can do something like this:

```twig
{{ render(url('dameev_sylius_supplier_shop_partial_supplier_index_by_channel', {'template': '@DameervSyliusSupplierPlugin/Shop/Supplier/_suppliers.html.twig'})) }}
```

### Form validation group

For forms use the validation group named `dameerv`
