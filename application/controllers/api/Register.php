<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';


class Register extends \Restserver\Libraries\REST_Controller
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
        $message = [];
        if ($this->input->post('user_email') && strlen($this->input->post('user_email')) > 0) {
            if (filter_var($this->input->post('user_email'), FILTER_VALIDATE_EMAIL)) {
                $data['user_email'] = $this->input->post('user_email');
            } else {
                $message['user_email'] = 'Invalid format of email.';
            }
        } else {
            $message['user_email'] = 'Email is a required field.';
        }
        if ($this->input->post('user_fname') && strlen($this->input->post('user_fname')) > 0) {
            $data['user_fname'] = $this->input->post('user_fname');
        } else {
            $message['user_fname'] = 'First Name is a required field.';
        }
        if ($this->input->post('user_lname') && strlen($this->input->post('user_lname')) > 0) {
            $data['user_lname'] = $this->input->post('user_lname');
        } else {
            $message['user_lname'] = 'Last Name is a required field.';
        }
        if ($this->input->post('user_password') && strlen($this->input->post('user_password')) > 0) {
            if (strlen($this->input->post('user_password')) < 8) {
                $message['user_password'] = 'Password is not strong enough';
            } else {
                $data['user_password'] = $this->input->post('user_password');
            }
        } else {
            $message['user_password'] = 'Password is a required field.';
        }
        if ($this->input->post('wishlist_name') && strlen($this->input->post('wishlist_name')) > 0) {
            $data['wishlist_name'] = $this->input->post('wishlist_name');
        } else {
            $message['wishlist_name'] = 'Wishlist Name is a required field.';
        }
        if ($this->input->post('wishlist_description') && strlen($this->input->post('wishlist_description')) > 0) {
            $data['wishlist_description'] = $this->input->post('wishlist_description');
        } else {
            $message['wishlist_description'] = 'Wishlist Description is a required field.';
        }
        if ($this->input->post('wishlist_occasion') && strlen($this->input->post('wishlist_occasion')) > 0) {
            $data['wishlist_occasion'] = $this->input->post('wishlist_occasion');
        } else {
            $message['wishlist_occasion'] = 'Wishlist Occasion is a required field.';
        }
        if (sizeof($message) > 0) {
            $item['message'] = 'All the fields have not been filled.';
            $item['registered'] = false;
            $item['empty_fields'] = true;
            $item['error_messages'] = $message;
            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            if ($this->user_model->insert_record($data) === 'Registered New User') {
                $item['message'] = 'New User has been registered.';
                $item['registered'] = true;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } // CREATED (201) being the HTTP response code}
            else {
                $item['message'] = 'Cannot register user as email is already in use.';
                $item['registered'] = false;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
