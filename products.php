<?php

class Product
{
	protected $_isDiscountable = true;

	public function isDiscountable(){
		return $this->_isDiscountable;
	}
}

class IceCream extends Product
{
	protected $_isDiscountable = false;
}

class Milkshake extends Product
{
}

class Float extends Product
{
}

// Examples
