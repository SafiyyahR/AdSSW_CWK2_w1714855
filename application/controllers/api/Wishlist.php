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
class Wishlist extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('wishlist_items_model');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['item_post']['limit'] = 500; // 100 requests per hour per user/key

    }

    function item_post()
    {
        $message = [];
        if ($this->input->post('wli_user_id') && strlen($this->input->post('wli_user_id')) > 0) {
            $data['wli_user_id'] = $this->input->post('wli_user_id');
        } else {
            $message['wli_user_id'] = 'User ID is a required field.';
        }
        if ($this->input->post('wli_title') && strlen($this->input->post('wli_title')) > 0) {
            $data['wli_title'] = $this->input->post('wli_title');
        } else {
            $message['wli_title'] = 'Wishlist Item Title is a required field.';
        }
        if ($this->input->post('wli_url') && strlen($this->input->post('wli_url')) > 0) {
            if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->input->post('wli_url'))) {
                $data['wli_url'] = $this->input->post('wli_url');
            } else {
                $message['wli_url'] = 'Invalid format of Wishlist Item URL';
            }
        } else {
            $message['wli_url'] = 'Wishlist Item URL is a required field.';
        }
        if ($this->input->post('wli_price') && $this->input->post('wli_price') > 0.0) {
            $data['wli_price'] = $this->input->post('wli_price');
        } else {
            $message['wli_price'] = 'Wishlist Item Price is a required field.';
        }
        if ($this->input->post('wli_priority')) {
            if ($this->input->post('wli_priority') > 1 && $this->input->post('wli_priority') <= 3) {
                switch ($this->input->post('wli_priority')) {
                    case 1:
                        $data['wli_priority'] = 'must have';
                        break;
                    case 2:
                        $data['wli_priority'] = 'would be nice to have';
                        break;
                    case 3:
                        $data['wli_priority'] = 'if you';
                        break;
                }
            } else {
                $message['wli_priority'] = 'Invalid choice of wishlist item priority';
            }
        } else {
            $message['wli_priority'] = 'Wishlist Item Priority is a required field.';
        }
        if (sizeof($message) > 0) {
            $item['message'] = 'All the fields have not been filled.';
            $item['added_item'] = false;
            $item['empty_fields'] = true;
            $item['error_messages'] = $message;
            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $this->wishlist_items_model->insert_record($data);
            $item['message'] = 'New Wishlist Item has been added.';
            $item['added_item'] = true;
            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        }
    }


    function item_delete()
    {
        if ($this->input->post('wli_id')) {
            $this->wli_id = $this->input->post('wli_id');
            $this->wishlist_items_model->delete_item($this);
            $data['message'] = 'The item has been deleted';
            $data['deleted_item'] = true;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $data['message'] = 'The wishlist item id has not been sent.';
            $data['deleted_item'] = false;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function items_get()
    {
        if ($this->input->post('user_id')) {
            $param['user_id'] = $this->input->post('user_id');
            $result = $this->wishlist_items_model->get_wishlist($param);
            if ($result['registered']) {
                $data['data'] = $result['results'];
                $data['message'] = 'The list is available';
                $data['retrieved'] = true;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } else {
                $data['message'] = 'No user is registered with that id.';
                $data['retrieved'] = false;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            }
        } else {
            $data['message'] = 'The user id has not been given.';
            $data['retrieved'] = false;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
