<?php

include 'products.php';

echo 'Running Tests';

// 1. ice cream should be discountable
function testIsDiscountable(){
	$icecream = new IceCream();
	$shake = new Milkshake();
	$float = new Float();

	$tests = [
		[$icecream->isDiscountable(), false],
		[$shake->isDiscountable(),    true],
		[$float->isDiscountable(),    true],
	];

	testEquals($tests);
}

testIsDiscountable();

///////////////////

function testEquals($tests) {
	foreach ($tests as $test) {
		if ($test[0] !== $test[1]) {
			echo "Fail: $input !== $expect";
		} else {
			echo 'Pass';
		}
	}
}