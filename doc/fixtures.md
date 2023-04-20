## Fixtures

This plugin comes with fixtures:

### Suppliers

Simply add this configuration on your fixture suite:

```yml
# config/packages/_sylius.yaml
sylius_fixtures:
    suites:
        default:
            fixtures:
                supplier:
                    options:
                        random: 3
```
