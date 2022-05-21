<?php

/* * ***
 * Version: 1.0.0
 *
 * Description of Payment Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TwoCheckoutPayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //load library, models etc.
        $this->load->model('Payment_model', 'payment');
        $this->load->library('TwoCheckoutApi');
    }

    // index method
    public function index() {
        $data = array();
        $data['metaDescription'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['metaKeywords'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['title'] = "2Checkout Payment Gateway Integration in Codeigniter - TechArise";
        $data['breadcrumbs'] = array('2Checkout Payment Gateway' => '#');
        $data['productInfo'] = $this->payment->getProduct();
        $this->load->view('2checkout/index', $data);
    }
    // checkout page
    public function checkout($id) {
        $data = array();
        $data['metaDescription'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['metaKeywords'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['title'] = "2Checkout Payment Gateway Integration in Codeigniter - TechArise";

        $this->payment->setProductID($id);
        $data['itemInfo'] = $this->payment->getProductDetails();
        $this->load->view('2checkout/2checkout', $data);
    }
    // callback
    public function callback() {
//        print_r($this->input->post());
//        die('callback');
        $data = array();
        if(!empty($this->input->post('token'))) {
            $product_id = $this->input->post('product_id');
            $product_name = $this->input->post('product_name');
            $addlineArr = array(
                'name' => $this->input->post('2checkout_name'),
                'email' => $this->input->post('2checkout_email'),
                'phoneNumber' => '900-000-0001',
                'addrLine' => '123 Main Street',
                'city' => 'Townsville',
                'state' => 'Ohio',
                'zipCode' => '43206',
                'country' => 'USA',
            );

            $merchantOrderID = strtolower(str_replace('.','',uniqid('', true)));
            $amount = $this->input->post('amount');
            $token = $this->input->post('token');
            try {
                // Charge params
                $charge = $this->twocheckoutapi->createCharge($merchantOrderID, $token, $amount,$addlineArr);
                echo "<pre>";
                print_r(var_dump($charge));
                die();
                // Check whether the charge is successful
                if ($charge['response']['responseCode'] == 'APPROVED') {
                    // Order details
                    $orderNumber = $charge['response']['orderNumber'];
                    $total = $charge['response']['total'];
                    $transactionID = $charge['response']['transactionId'];
                    $currency = $charge['response']['currencyCode'];
                    $status = $charge['response']['responseCode'];

                    // Insert order info to database
                    $this->payment->setTransactionID($transactionID);
                    $this->payment->setProductID($product_id);
                    $this->payment->setProductName($product_name);
                    $this->payment->setName($addlineArr['name']);
                    $this->payment->setEmail($addlineArr['email']);
                    $this->payment->setAddress($addlineArr['addrLine']);
                    $this->payment->setPrice($amount);
                    $this->payment->setTotal($amount);
                    $this->payment->setCurrency($currency);
                    $this->payment->setCreatedDate(time());
                    $this->payment->setModifiedDate(time());
                    $this->payment->setStatus($status);
                    $orderID = $this->payment->createOrder();

                    $statusMsg = '<h2>Thanks for your Order!</h2>';
                    $statusMsg .= '<h4>The transaction was successful. Order details are given below:</h4>';
                    $statusMsg .= "<p>Order ID: {$merchantOrderID}</p>";
                    $statusMsg .= "<p>Order Number: {$orderNumber}</p>";
                    $statusMsg .= "<p>Transaction ID: {$transactionID}</p>";
                    $statusMsg .= "<p>Order Total: {$total} {$currency}</p>";
                }

            } catch (Twocheckout_Error $e) {
                $statusMsg = '<h2>Transaction failed!</h2>';
                $statusMsg .= '<p>'.$e->getMessage().'</p>';
            }

        } else {
            $statusMsg = "Error on form submission.";
        }
        die($statusMsg);
        $this->session->set_flashdata('paymentInfo', $statusMsg);
        redirect('2checkout/success');
    }
    // success
    public function success() {
        $data = array();
        $data['metaDescription'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['metaKeywords'] = '2Checkout Payment Gateway Integration in Codeigniter';
        $data['title'] = "2Checkout Payment Gateway Integration in Codeigniter - TechArise";
        $data['msg'] = $this->session->flashdata('paymentInfo');
        $this->load->view('2checkout/success', $data);
    }
}
?>