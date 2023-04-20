## Installation

1. Run `composer require dameerv/sylius-supplier-plugin --no-scripts`

2. Enable the plugin in bundles.php

```php
<?php
// config/bundles.php

return [
    // ...
    Dameerv\SyliusSupplierPlugin\DameervSyliusSupplierPlugin::class => ['all' => true],
];
```

3. Import the plugin configurations

```yml
# config/packages/_sylius.yaml
imports:
    # ...
    - { resource: "@DameervSyliusSupplierPlugin/Resources/config/config.yaml" }
```

4. Add the shop and admin routes

```yml
# config/routes.yaml
dameev_sylius_supplier_plugin_admin:
    resource: "@DameervSyliusSupplierPlugin/Resources/config/routing/admin.yaml"
    prefix: /admin

dameev_sylius_supplier_plugin_shop:
    resource: "@DameervSyliusSupplierPlugin/Resources/config/routing/shop.yaml"
    prefix: /{_locale}/suppliers
    requirements:
        _locale: ^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$
```

5. Include traits and override the models

```php
<?php
// src/Entity/Channel/Channel.php

// ...
use Doctrine\ORM\Mapping as ORM;
use Dameerv\SyliusSupplierPlugin\Entity\SuppliersAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SuppliersTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements SuppliersAwareInterface
{
    use SuppliersTrait {
        __construct as private initializeSuppliersCollection;
    }

    public function __construct()
    {
        parent::__construct();

        $this->initializeSuppliersCollection();
    }

    // ...
}
```

```php
<?php
// src/Entity/Product/Product.php

// ...
use Doctrine\ORM\Mapping as ORM;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierAwareInterface;
use Dameerv\SyliusSupplierPlugin\Entity\SupplierTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements SupplierAwareInterface
{
    use SupplierTrait;

    // ...
}
```

```php
<?php
// src/Repository/ProductRepository.php

// ...
use Dameerv\SyliusSupplierPlugin\Repository\ProductRepositoryInterface;
use Dameerv\SyliusSupplierPlugin\Repository\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;

    // ...
}
```

```yml
# config/packages/_sylius.yaml
sylius_product:
    resources:
        product:
            classes:
                repository: App\Repository\ProductRepository
```

6. Add the supplier select box to the product form edit page. So, you need to run `mkdir -p templates/bundles/SyliusAdminBundle/Product/Tab` then `cp vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Product/Tab/_details.html.twig templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig` and then add the form widget

```twig
{# ... #}
{{ form_row(form.enabled) }}
{{ form_row(form.supplier) }}
{# ... #}
```

7. Create logo folder: run `mkdir public/media/supplier-logo -p` and insert a .gitkeep file in that folder

8. Finish the installation updating the database schema and installing assets

```
php bin/console doctrine:migrations:migrate
php bin/console sylius:theme:assets:install
php bin/console cache:clear
```
