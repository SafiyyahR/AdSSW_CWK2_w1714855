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
        $this->load->model('user_model');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 100 requests per hour per user/key

    }


    public function user_post()
    {

        if ($this->input->post('user_email')) {
            $data['user_email'] = $this->input->post('user_email');
        } else {
            $message['user_email'] = 'Email is a required field.';
        }
        if ($this->input->post('user_fname')) {
            $data['user_fname'] = $this->input->post('user_fname');
        } else {
            $message['user_fname'] = 'First Name is a required field.';
        }
        if ($this->input->post('user_lname')) {
            $data['user_lname'] = $this->input->post('user_lname');
        } else {
            $message['user_lname'] = 'Last Name is a required field.';
        }
        if ($this->input->post('user_password')) {
            if (strlen($this->input->post('user_password')) < 8) {
                $message['user_password'] = 'Password is not strong enough';
            } else {
                $data['user_password'] = $this->input->post('user_password');
            }
        } else {
            $message['user_password'] = 'Password is a required field.';
        }
        if ($this->input->post('wishlist_name')) {
            $data['wishlist_name'] = $this->input->post('wishlist_name');
        } else {
            $message['wishlist_name'] = 'Wishlist Name is a required field.';
        }
        if ($this->input->post('wishlist_description')) {
            $data['wishlist_description'] = $this->input->post('wishlist_description');
        } else {
            $message['wishlist_description'] = 'Wishlist Description is a required field.';
        }
        if ($this->input->post('wishlist_occasion')) {
            $data['wishlist_occasion'] = $this->input->post('wishlist_occasion');
        } else {
            $message['wishlist_occasion'] = 'Wishlist Occasion is a required field.';
        }
        if (sizeof($message) > 0) {
            $data['message'] = 'All the fields have not been filled.';
            $data['registered'] = false;
            $data['data'] = $message;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            if ($this->user_model->insert_record($data) === 'Registered New User') {
                $data['message'] = 'New User has been registered.';
                $data['registered'] = true;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } // CREATED (201) being the HTTP response code}
            else {
                $data['message'] = 'Cannot register user as email is already in use.';
                $data['registered'] = false;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
