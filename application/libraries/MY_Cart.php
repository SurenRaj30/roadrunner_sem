<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    /**
	 * only allow safe product names
	 *
	 * @var bool
	 */
	public $product_name_safe = FALSE;

}