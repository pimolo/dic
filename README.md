# dic
A simple and PSR-11 compliant dependency injection container.

Killer feature: you don't need to provide an identifier as it defaults to the FQCN!

(note it doesn't work with scalars https://github.com/pimolo/dic/issues/1 but why using scalars in a DIC :smile:?)

## Usage

```php
<?php

use Pimolo\DIC\Container;
use Psr\Container\ContainerInterface;

require_once 'vendor/autoload.php';

$container = new Container();

$container->set(function () {
    return new \DateTime;
}, 'now');

$container->has('now'); // true

$container->set(function (ContainerInterface $container) {
    return new \SomeManager($container->get(\DateTime::class));
});
```
