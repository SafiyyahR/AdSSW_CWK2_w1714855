<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Login extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('wishlist_items_model');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['wishlist_item_post']['limit'] = 500; // 100 requests per hour per user/key

    }

    function wishlist_item_post()
    {
        if ($this->input->post('wli_user_id')) {
            $data['wli_user_id'] = $this->input->post('wli_user_id');
        } else {
            $message['wli_user_id'] = 'User ID is a required field.';
        }
        if ($this->input->post('wli_title')) {
            $data['wli_title'] = $this->input->post('wli_title');
        } else {
            $message['wli_title'] = 'Wishlist Item Title is a required field.';
        }
        if ($this->input->post('wli_url')) {
            $data['wli_url'] = $this->input->post('wli_url');
        } else {
            $message['wli_url'] = 'Wishlist Item URL is a required field.';
        }
        if ($this->input->post('wli_price')) {
            $data['wli_price'] = $this->input->post('wli_price');
        } else {
            $message['wli_price'] = 'Wishlist Item Price is a required field.';
        }
        if ($this->input->post('wli_priority')) {
            $data['wli_priority'] = $this->input->post('wli_priority');
        } else {
            $message['wli_priority'] = 'Wishlist Item Priority is a required field.';
        }
        if (sizeof($message) > 0) {
            $data['message'] = 'All the fields have not been filled.';
            $data['added_item'] = false;
            $data['data'] = $message;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->wishlist_items_model->insert_record($data);
            $data['message'] = 'New Wishlist has been added.';
            $data['added_item'] = true;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        }
    }

    function wishlist_item_delete(){
        if($this->input->post('wli_id')){
            $this->wli_id= $this->input->post('wli_id');
            $this->wishlist_items_model->delete_item($this);
            $data['message'] = 'The item has been deleted';
            $data['deleted_item'] = true;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        }else{
            $data['message'] = 'The wishlist item id has not been sent.';
            $data['deleted_item'] = false;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
