<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('product_form');		
	}

	public function check()
	{
//        $this->load->library('skril/Skrillapi');

        $parameters = [
            'user_email' => 'demo@demo.com',
            'secret_word' => 'secret word',
            'merchant_id' => 'this is sample id',
            'mqi' => 'this is sample mqi'
        ];
        $this->load->library('skril/skrillapi', $parameters);

        /**
         * Used for creating the redirection URL for making payments
         *
         * @param array $args The parameters to be send to Skrill
         * @param string $request_type The type of request charge / refund
         * @param string $sid The session id
         *
         */
        $request_type = 'charge';
        $args = [];
        $sid = '';
        // Pass your data in parameters
        $response = $this->skrillapi->prepareRequest($args, $request_type, $sid);
        print_r($response);

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
