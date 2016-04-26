<?php
include 'products.php';

// 1. create a product of each type
$icOptions = ['scoop 1' => 'vanilla', 'vessel' => 'cup'];
$icecream = new IceCream($icOptions);
echo "icecream price: ";
echo $icecream->getPrice();
echo "\n";

$shakeOptions = ['ice cream flavor' => 'vanilla', 'milk' => 'skim', 'soda flavor' => 'root beer'];
$shake = new Milkshake($shakeOptions);
echo "shake price: ";
echo $shake->getPrice();
echo "\n";

$floatOptions = ['scoops' => ['vanilla'], 'soda flavor' => 'root beer'];
$float = new Float($floatOptions);
echo "float price: ";
echo $float->getPrice();
echo "\n";

// 2. apply a discount to a product
$float->setDiscountAmount(-5.00);
echo "float price with discount: ";
echo $float->getPrice();