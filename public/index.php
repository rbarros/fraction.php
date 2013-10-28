<?php
/**
 * This file is part of the Nocriz API (http://nocriz.com)
 *
 * Copyright (c) 2013  Nocriz API (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

/**
 * Nocriz API 
 *
 * @package  Nocriz
 * @author   Ramon Barros <contato@ramon-barros.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| This application is installed by the Composer, 
| that provides a class loader automatically.
| Use it to seamlessly and feel free to relax.
|
*/

require __DIR__.'/../app/bootstrap.php';

use Fraction\Fraction;

echo "<pre>";

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

echo "</pre>";