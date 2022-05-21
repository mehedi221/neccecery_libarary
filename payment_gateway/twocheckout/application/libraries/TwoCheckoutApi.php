<?php
/* * ***
 * Version: 1.0.0
 *
 * Description of 2Checkout Payment Gateway Library
 *
 * @package: CodeIgniter
 * @category: Libraries
 * @author TechArise Team
 * @email  info@techarise.com
 *
 * *** */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class TwoCheckoutApi {
	var $CI;
	var $api_error;

	function __construct(){
		$this->api_error = '';
		$this->CI =& get_instance();

		// Include the 2Checkout library
		require APPPATH .'third_party/2checkout/Twocheckout.php';

		// Set API key
		Twocheckout::sellerId(TWOCHECKOUT_SELLER_ID);
		Twocheckout::privateKey(TWOCHECKOUT_PRIVATE_KEY);
//		Twocheckout::sandbox(true);

	}

	// create Charge method
	function createCharge($merchantOrderID, $token, $amount, $billingArr=array()){
		// corrency code
		$currency = CURRENCY_CODE;
		try {
			// Charge a credit or a debit card
			$charge = Twocheckout_Charge::auth(array(
				"merchantOrderId" => $merchantOrderID,
				"token"      => $token,
				"currency"   => $this->CI->config->item('currency_code'),
				"total"      => $amount,
				"billingAddr" => array(
					"name" => $billingArr['name'],
					"addrLine1" => $billingArr['addrLine'],
					"city" => $billingArr['city'],
					"state" => $billingArr['state'],
					"zipCode" => $billingArr['zipCode'],
					"country" => $billingArr['country'],
					"email" => $billingArr['email'],
					"phoneNumber" => $billingArr['phoneNumber']
				)
			));
			// Retrieve charge information
			return $charge;
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
	}
}
?>