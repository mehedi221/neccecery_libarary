<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('product_form');		
	}

	public function check()
	{
        //include Stripe PHP library
        require_once APPPATH."third_party/stripe/init.php";
        $publishableKey = "pk_test_51JC6x5GmKnguJE09odlgJKYQDYA0qtN4TcPyzWIDK4iNovINdRRQtgMM1dL3tRTu9uEvCV4ItmJn3CfFqLCFtghE00doEzT4QV";
        $secretKey = "sk_test_51JC6x5GmKnguJE09wtcE5Ox1c9sqOOtDswUuhEOg5NiumrFROGHxCM4owaOGdObO8Y1knwQ7SccAJb7NPX1U4SSg00hjnSVgXB";
        try {
            // Use Stripe's library to make requests...
            $publicStripe = new \Stripe\StripeClient($publishableKey);


            $tokens = $publicStripe->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 8,
                    'exp_year' => 2023,
                    'cvc' => '314',
                ],
            ]);

            $token = $tokens->id;
//            die($token);
            $email = "shoriful00@gmail.com";

            //add customer to stripe
            $stripe = new \Stripe\StripeClient($secretKey);

            $allCustomers = $stripe->customers->all(
                ['email'=>$email]
            );
            echo "<pre>";
            print_r($allCustomers);
            die();

            $customer = $stripe->customers->create(array(
                'email' => $email,
                'source'  => $token
            ));
            echo "<pre>";
            print_r($customer);
            die();
            $charge = $stripe->charges->create([
                'amount' => 300,
                'currency' => 'usd',
                'customer' => $customer->id, // obtained with Stripe.js
                'description' => 'My First Test Charge (created for API docs) testss'
            ]);
            echo '<pre>';
            print_r($charge);

        } catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            echo '<pre>';
            print_r($e->getError()->message);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            echo '<pre>';
            print_r($e->getError()->message);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            echo '<pre>';
            print_r($e->getError()->message);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            echo '<pre>';
            print_r($e->getError()->message);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            echo '<pre>';
            print_r($e->getError()->message);
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo '<pre>';
            print_r($e->getError()->message);
        }

//        print_r($charge);
        die();

//        die($token);


		//check whether stripe token is not empty
		if(!empty($_POST['stripeToken']))
		{
			//get token, card and user info from the form
			$token  = $_POST['stripeToken'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$card_num = $_POST['card_num'];
			$card_cvc = $_POST['cvc'];
			$card_exp_month = $_POST['exp_month'];
			$card_exp_year = $_POST['exp_year'];
			
			//include Stripe PHP library
			require_once APPPATH."third_party/stripe/init.php";
			
			//set api key
			$stripe = array(
                "secret_key"      => "sk_test_51JC6x5GmKnguJE09wtcE5Ox1c9sqOOtDswUuhEOg5NiumrFROGHxCM4owaOGdObO8Y1knwQ7SccAJb7NPX1U4SSg00hjnSVgXB",
		        "publishable_key" => "pk_test_51JC6x5GmKnguJE09odlgJKYQDYA0qtN4TcPyzWIDK4iNovINdRRQtgMM1dL3tRTu9uEvCV4ItmJn3CfFqLCFtghE00doEzT4QV"
			);
			
			\Stripe\Stripe::setApiKey($stripe['secret_key']);

			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));
			
			//item information
			$itemName = "Stripe Donation";
			$itemNumber = "PS123456";
			$itemPrice = 50;
			$currency = "usd";
			$orderID = "SKA92712382139";
			
			//charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $itemPrice,
				'currency' => $currency,
				'description' => $itemNumber,
				'metadata' => array(
					'item_id' => $itemNumber
				)
			));
			
			//retrieve charge details
			$chargeJson = $charge->jsonSerialize();
			echo "<pre>";
			print_r($chargeJson);
			echo "</pre>";
			die();

			//check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
				//order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];
				$date = date("Y-m-d H:i:s");
			
				
				//insert tansaction data into the database
				$dataDB = array(
					'name' => $name,
					'email' => $email, 
					'card_num' => $card_num, 
					'card_cvc' => $card_cvc, 
					'card_exp_month' => $card_exp_month, 
					'card_exp_year' => $card_exp_year, 
					'item_name' => $itemName, 
					'item_number' => $itemNumber, 
					'item_price' => $itemPrice, 
					'item_price_currency' => $currency, 
					'paid_amount' => $amount, 
					'paid_amount_currency' => $currency, 
					'txn_id' => $balance_transaction, 
					'payment_status' => $status,
					'created' => $date,
					'modified' => $date
				);

				if ($this->db->insert('orders', $dataDB)) {
					if($this->db->insert_id() && $status == 'succeeded'){
						$data['insertID'] = $this->db->insert_id();
						$this->load->view('payment_success', $data);
						// redirect('Welcome/payment_success','refresh');
					}else{
						echo "Transaction has been failed";
					}
				}
				else
				{
					echo "not inserted. Transaction has been failed";
				}

			}
			else
			{
				echo "Invalid Token";
				$statusMsg = "";
			}
		}
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
