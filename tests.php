<?php

include 'products.php';

echo "Running Tests \n";

run();
function run(){
	testIsDiscountable();
	testOptions();
}

// 1. ice cream should be discountable
function testIsDiscountable(){
	debugHeader('Testing Discounts');

	$icOptions = ['scoop 1' => 'vanilla', 'vessel' => 'cup'];
	$icecream = new IceCream($icOptions);

	$shakeOptions = ['ice cream flavor' => 'vanilla', 'milk' => 'skim', 'soda flavor' => 'root beer'];
	$shake = new Milkshake($shakeOptions);

	$floatOptions = ['scoops' => ['vanilla'], 'soda flavor' => 'root beer'];
	$float = new Float($floatOptions);

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
	debugHeader('Testing Options');

	// IceCream
	$tests = [
		// valid
		[['scoop 1' => 'vanilla', 'vessel' => 'cup'], true],
		[['scoop 1' => 'strawberry', 'scoop 2' => 'chocolate', 'vessel' => 'cup'], true],
		[['scoop 1' => 'vanilla', 'vessel' => 'waffle cone'], true],

		// invalid
		[[], false],
		[['scoop 2' => 'vanilla', 'vessel' => 'waffle cone'], false],
		[['scoop 1' => 'trash can', 'vessel' => 'waffle cone'], false],
		[['scoop 1' => 'vanilla', 'vessel' => 'on the floor'], false],
	];

	foreach ($tests as $test) {
		$options = $test[0];
		$expectation = $test[1];
		$ic = new IceCream($options);
		assertEquals($ic->isValid(), $expectation);
	}

	// Milkshakes
	$tests = [
		// valid
		[['ice cream flavor' => 'vanilla', 'milk' => 'skim', 'soda flavor' => 'root beer'], true],
		[['ice cream flavor' => 'chocolate', 'milk' => 'skim', 'soda flavor' => 'root beer'], true],
		[['ice cream flavor' => 'chocolate', 'milk' => 'whole', 'soda flavor' => 'cream soda'], true],

		// invalid
		[['milk' => 'skim', 'soda flavor' => 'root beer'], false],
		[['ice cream flavor' => 'vanilla', 'soda flavor' => 'root beer'], false],
		[['ice cream flavor' => 'vanilla', 'milk' => 'skim'], false],
		[['ice cream flavor' => 'trash can', 'milk' => 'skim', 'soda flavor' => 'root beer'], false],
		[['ice cream flavor' => 'vanilla', 'milk' => 'goat', 'soda flavor' => 'root beer'], false],
		[['ice cream flavor' => 'vanilla', 'milk' => 'skim', 'soda flavor' => 'prune juice'], false],
	];

	foreach ($tests as $test) {
		$options = $test[0];
		$expectation = $test[1];
		$ms = new Milkshake($options);
		assertEquals($ms->isValid(), $expectation);
	}

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

function debugHeader($some) {
	echo "\n$some \n";
	echo "------------------- \n";
}