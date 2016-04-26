<?php

class Product
{
	protected $_isDiscountable = true;

	/**
	 * An array of options and rules for creating a product
	 * @var array
	 */
	protected $_options = [];
	protected $_isValid = true;
	protected $_price = 0;

	function __construct($selectedOptions)
	{
		$isValid = $this->_validateSelection($selectedOptions);
		$this->_isValid = $isValid;
		if ($isValid) {
			$this->selectedOptions = $selectedOptions;
		}
	}

	protected function _validateSelection($selections){
		debug('performing validation');
		debug('---------------------');

		$isValid = true;
		foreach ($this->_options as $key => $option) {
			$so = $selections[$key];
			debug("evaluating option: $key ");
			debug("- selected option: $so");

			$isRequired = $option['isRequired'];

			// Check that we have an input
			if ($isRequired && is_null($so)){
				debug("- required option left out, continue");
				$isValid = false;
				continue; //TODO: could be `break` for perf
			}

			// Check option selection
			$inOptions = (false !== array_search($so, $option['options']));
			if ($isRequired && !$inOptions) {
				debug("- invalid option selected ");
				$isValid = false;
				continue; //TODO: could be `break` for perf
			}

			debug("valid option");
		}

		debug("isValid: $isValid");
		return $isValid;
	}

	public function getOptions(){
		return $this->_options;
	}

	public function isDiscountable(){
		return $this->_isDiscountable;
	}

	public function isValid(){
		return $this->_isValid;
	}

	/**
	 * getPrice
	 * @return float Get the price of the product including discounts
	 */
	public function getPrice(){
		if (!$this->_isDiscountable) {
			return $this->_price;
		}

		// minimum of zero
		return ($this->_discountAmount > $this->_price) ? 0.00 : $this->_price + $this->_discountAmount;
	}

	/**
	 * setDiscountAmount
	 * @param float $amount The amount to be subtracted from the price
	 */
	public function setDiscountAmount($amount){
		if (!$this->_isDiscountable || !is_float($amount) || $amount > 0) {
			return false;
		}

		$this->_discountAmount = floatval($amount);
		return $this->_discountAmount;
	}
}

class IceCream extends Product
{
	protected $_price = 5.99;
	protected $_options = [
		'scoop 1' => [
			'isRequired' => true,
			'options' => ['vanilla', 'chocolate', 'strawberry', 'mint chocolate chip', 'pistachio'],
		],
		'scoop 2' => [
			'isRequired' => false,
			'options' => ['vanilla', 'chocolate', 'strawberry', 'mint chocolate chip', 'pistachio'],
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
	protected $_price = 8.99;
	protected $_options = [
		'ice cream flavor' => [
			'isRequired' => true,
			'options' => ['vanilla', 'chocolate', 'strawberry', 'mint chocolate chip', 'pistachio'],
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
	protected $_price = 6.99;
	protected $_options = [
		'scoops' => ['vanilla', 'chocolate', 'strawberry', 'mint chocolate chip', 'pistachio'],
		'soda flavor' => ['root beer', 'cola', 'cream soda'],
	];

	protected function _validateSelection($selectedOptions) {
		$d = true;
		debug("performing validation");
		debug("---------------------");

		$isValid = true;

		// 1. Scoops
		$selectedScoops = $selectedOptions['scoops'];

		// Required
		if (!$selectedScoops) {
			debug('selected scoops not specified');
			$isValid = false;
		}

		// Legal flavor choice
		if ($selectedScoops) {
			foreach ($selectedScoops as $selectedFlavor) {
				if (false === array_search($selectedFlavor, $this->_options['scoops'])) {
					debug('non valid flavor selection');
					$isValid = false;
					break;
				}
			}
		}

		// 2. Soda flavor
		$selectedSoda = $selectedOptions['soda flavor'];

		// Required
		if (!$selectedSoda || !is_string($selectedSoda)) {
			$isValid = false;
			debug('emptyish soda selection');
		}

		// Legal soda choice
		if (false === array_search($selectedSoda, $this->_options['soda flavor'])) {
			debug('non valid soda flavor selection');
			$isValid = false;
		}

		return $isValid;
	}
}

/**
 * Helper function for echoing debug level info
 */
function debug($val) {
	$isEnabled = false;
	if ($isEnabled) {
		echo "$val\n";
	}
}