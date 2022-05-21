<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Paypal extends CI_Controller
{
    function  __construct() {
        parent::__construct();
        $this->load->library('paypal_lib');
        $this->load->model('product');
        $this->load->database();
    }
    function index(){
        $data = array();
//get products inforamtion from database table
        $data['products'] = $this->product->getRows();
//loav view and pass the products information to view
        $this->load->view('products/index', $data);
    }
    function buyProduct($id){
//Set variables for paypal form
        $returnURL = base_url().'paypal/success?method_id=10'; //payment success url
        $cancelURL = base_url().'paypal/cancel'; //payment cancel url
        $notifyURL = base_url().'paypal/ipn'; //ipn url
//get particular product data
        $product = $this->product->getRows($id);
        $amount = 7000;
        $userID = 1; //current user id
        $logo = base_url().'Your_logo_url';
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $product['name']);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number',  $product['id']);
        $this->paypal_lib->add_field('amount',  $amount);
        $this->paypal_lib->image($logo);
        $this->paypal_lib->paypal_auto_form();
    }
    function success(){
        //get the transaction data
        $paypalInfo = $this->input->get();
        echo "<pre>";
        print_r($paypalInfo);
        die();
        $data['item_number'] = $paypalInfo['item_number'];
        $data['txn_id'] = $paypalInfo["tx"];
        $data['payment_amt'] = $paypalInfo["amt"];
        $data['currency_code'] = $paypalInfo["cc"];
        $data['status'] = $paypalInfo["st"];
        //pass the transaction data to view
        $this->load->view('paypal/success', $data);
    }
    function cancel(){
    //if transaction cancelled
        $this->load->view('paypal/cancel');
    }
    function ipn(){
//paypal return transaction details array
        $paypalInfo    = $this->input->post();
        $data['user_id'] = $paypalInfo['custom'];
        $data['product_id']    = $paypalInfo["item_number"];
        $data['txn_id']    = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["mc_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status']    = $paypalInfo["payment_status"];
        $paypalURL = $this->paypal_lib->paypal_url;
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
//check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
//insert the transaction data into the database
            $this->product->storeTransaction($data);
        }
    }
}