<?php

include 'products.php';

echo "Running Tests \n";

run();
function run(){
	// testIsDiscountable();
	testOptions();
}

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

	foreach ($tests as $test) {
		assertEquals($test[0], $test[1]);
	}
}

// 2. options
function testOptions() {
	// IceCream
	// Milkshakes
	// Floats
	$tests = [
		// valid
		[['scoops' => ['vanilla'], 'soda flavor' => 'root beer'], true],
		[['scoops' => ['chocolate'], 'soda flavor' => 'cola'], true],
		[['scoops' => ['strawberry'], 'soda flavor' => 'root beer'], true],

		// invalid
		[['scoops' => [''], 'soda flavor' => 'root beer'], false],
		[['soda flavor' => 'root beer'], false],
		[['scoops' => ['strawberry'], 'soda flavor' => 'beer'], false],
	];

	foreach ($tests as $test) {
		$options = $test[0];
		$expectation = $test[1];
		$fl = new Float($options);
		assertEquals($fl->isValid(), $expectation);
	}
}

///////////////////

function assertEquals($a, $b){
	if ($a !== $b) {
		echo "Fail: $a !== $b \n";
	} else {
		echo "Pass \n";
	}
}