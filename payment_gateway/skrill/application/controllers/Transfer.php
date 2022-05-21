<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {

	public function index()
	{
		$this->load->view('payment_form');
	}

	public function payment()
	{
        //include Stripe PHP library
        require_once APPPATH."third_party/stripe/init.php";

        //set api key
        $stripe = array(
            "secret_key"      => "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",
            "publishable_key" => "pk_live_51JC6x5GmKnguJE09X3HMKxqFUiR24dP3TlPiiPWUbSpLSFODn4CuclpjHYd4YxE7BhKu14xxYQ4aySFR9yajqZoV00YKyRqnRo"
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        // Create a PaymentIntent:
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'transfer_group' => 'ORDER10',
        ]);



        // Create a Transfer to a connected account (later):
        $transfer = \Stripe\Transfer::create([
            'amount' => 100,
            'currency' => 'usd',
//            'source_transaction' => 'acct_1JC6x5GmKnguJE09',
            'destination' => 'acct_12QkqYGSOD4VcegJ',
            'transfer_group' => 'ORDER10',
        ]);

        echo "<pre>";
        print_r($transfer);
        die();

        // Create a second Transfer to another connected account (later):
        $transfer = \Stripe\Transfer::create([
            'amount' => 100,
            'currency' => 'usd',
            'destination' => '000123456',
            'transfer_group' => 'ORDER10',
        ]);
	}

	public function payment_success()
	{
		$this->load->view('payment_success');
	}

	public function payment_error()
	{
		$this->load->view('payment_error');
	}

	public function help()
	{
		$this->load->view('help');
	}
}
