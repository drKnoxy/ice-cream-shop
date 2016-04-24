<?php

class Product
{
	protected $_isDiscountable = true;
	protected $_options = [];

	function __construct($selectedOptions)
	{
		$this->selectedOptions = $selectedOptions;
		$isValid = $this->_validateOptions();
		return $isValid;
	}

	protected function _validateOptions(){
		echo "performing validation \n";
		echo "---------------------\n";
		$isValid = true;

		foreach ($this->_options as $key => $option) {
			$so = $this->selectedOptions[$key];
			echo "evaluating option: $key \n";
			echo "selected option:";
			var_dump($so);

			$isRequired = $option['isRequired'];

			// Check that we have an input
			if ($isRequired && is_null($so)){
				echo "required option left out, continue \n";
				$isValid = false;
				continue;
			}

			// Check option selection
			$inOptions = array_search($so, $option['options']) === false;
			if ($isRequired && $inOptions) {
				echo "invalid option selected \n";
				$isValid = false;
				continue;
			}
		}

		echo "isValid:";
		var_dump($isValid);

		return $isValid;
	}

	public function getOptions(){
		return $this->_options;
	}

	public function isDiscountable(){
		return $this->_isDiscountable;
	}
}

class IceCream extends Product
{
	//TODO: fill in more flavors
	protected $_options = [
		'scoop 1' => [
			'isRequired' => true,
			'options' => ['vanilla', 'chocolate'],
		],
		'scoop 2' => [
			'isRequired' => false,
			'options' => ['vanilla', 'chocolate'],
		],
		'vessel' => [
			'isRequired' => true,
			'options' => ['waffle cone', 'cup', 'in your hand'],
		]
	];

	protected $_isDiscountable = false;
}

class Milkshake extends Product
{
	protected $_options = [
		'ice cream flavor' => [
			'isRequired' => true,
			'options' => ['vanilla', 'chocolate'],
		],
		'milk' => [
			'isRequired' => true,
			'options' => ['skim', 'whole', '2%'],
		],
		'soda flavor' => [
			'isRequired' => true,
			'options' => ['root beer', 'cola', 'cream soda'],
		]
	];
}

class Float extends Product
{
	protected $_options = [
		//TODO: any number of scoops
		"scoops" => ["vanilla", "chocolate"],
		"soda flavor" => ["root beer", "cola", "cream soda"],
	];
}

// Examples
$icOptions = ["scoop 1" => "vanilla", "vessel" => "wafflecone"];
$ic = new IceCream($icOptions);

// $shake = new Milkshake();
// $float = new Float();

// $set = [$ic, $shake, $float];
// foreach ($set as $product) {
// 	$o = $product->getOptions();
// 	echo "\n";
// 	echo get_class($product);
// 	echo "\n------------\n";
// 	var_dump($o);
// }