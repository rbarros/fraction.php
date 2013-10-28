# fraction.php

### Fraction

Você pode instalar com Composer (recomendado) ou manualmente.

```
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --prefer-source
```

## Examples

```
require __DIR__.'/../app/bootstrap.php';

use Fraction\Fraction;

$fraction = new Fraction(1);
var_dump($fraction->getFraction());
// 1/1

$fraction = new Fraction(2);
var_dump($fraction->getFraction());
// 2/1

$fraction = new Fraction(0.5);
var_dump($fraction->getFraction());
// 1/2

$fraction = new Fraction(0.08);
var_dump($fraction->getFraction());
// 2/25

$fraction = new Fraction(0.175);
var_dump($fraction->getFraction());
// 7/40

$fraction = new Fraction(0.666666666);
var_dump($fraction->getFraction());
// 2/3

$fraction = new Fraction(0.166666666);
var_dump($fraction->getFraction());
// 1/6

$fraction = new Fraction(0.022222222);
var_dump($fraction->getFraction());
// 1/45

$fraction = new Fraction(0.012345679);
var_dump($fraction->getFraction());
// 1/81

```

### Tests

Tests sem Coverage
```
$ bin/phpunit --configuration phpunit.xml
```

Tests com coverage
```
# Requer extensão Xdebug.
$ bin/phpunit --configuration phpunit.xml.dist
```