<?php
/**
 * @package 2Checkout :  CodeIgniter 2Checkout Gateway Model
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 * Description of Contact Controller
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends CI_Model {
    private $_productID;
    private $_transactionID;
    private $_name;
    private $_email;
    private $_address;
    private $_productName;
    private $_price;
    private $_total;
    private $_currency;
    private $_createdDate;
    private $_modifiedDate;
    private $_status;

    public function setProductID($productID) {
        $this->_productID = $productID;
    }
    public function setTransactionID($transactionID) {
        $this->_transactionID = $transactionID;
    }
    public function setName($name) {
        $this->_name = $name;
    }
    public function setEmail($email) {
        $this->_email = $email;
    }
    public function setAddress($address) {
        $this->_address = $address;
    }
    public function setProductName($productName) {
        $this->_productName = $productName;
    }
    public function setPrice($price) {
        $this->_price = $price;
    }
    public function setTotal($total) {
        $this->_total = $total;
    }
    public function setCurrency($currency) {
        $this->_currency = $currency;
    }
    public function setCreatedDate($createdDate) {
        $this->_createdDate = $createdDate;
    }
    public function setModifiedDate($modifiedDate) {
        $this->_modifiedDate = $modifiedDate;
    }
    public function setStatus($status) {
        $this->_status = $status;
    }

    public function getProduct() {
        $this->db->select(array('p.product_id', 'p.name', 'p.description', 'p.price', 'p.image'));
        $this->db->from('product as p');
        $query = $this->db->get();
        return $query->result_array();
    }
    // getProduct Details
    public function getProductDetails() {
        $this->db->select(array('p.product_id', 'p.name', 'p.description', 'p.price', 'p.image'));
        $this->db->from('product as p');
        $this->db->where('p.product_id', $this->_productID);
        $query = $this->db->get();
        return $query->row_array();
    }

    // create Order
    public function createOrder() {
        $data = array(
            'transaction_id' => $this->_transactionID,
            'name' => $this->_name,
            'email' => $this->_email,
            'address' => $this->_address,
            'product_id' => $this->_productID,
            'product_name' => $this->_productName,
            'product_price' => $this->_price,
            'total' => $this->_total,
            'currency' => $this->_currency,
            'created_date' => $this->_createdDate,
            'modified_date' => $this->_modifiedDate,
            'status' => $this->_status,
        );
        $this->db->insert('orders', $data);
        return $last_id = $this->db->insert_id();
    }
}
?>