<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

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

    function user_post()
    {
        $message = [];
        if ($this->input->post('user_email') && strlen($this->input->post('user_email')) > 0) {
            $data['user_email'] = $this->input->post('user_email');
        } else {
            $message['user_email'] = 'Email is a required field.';
        }
        if ($this->input->post('user_password') && strlen($this->input->post('user_password')) > 0) {
            $data['user_password'] = $this->input->post('user_password');
        } else {
            $message['user_password'] = 'Password is a required field.';
        }
        if (sizeof($message) > 0) {
            $item['message'] = 'All the fields have not been filled.';
            $item['valid_login'] = false;
            $item['empty_fields'] = true;
            $item['error_messages'] = $message;
            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $valid_login = $this->user_model->validate_credentials($data);
            if ($valid_login != 'The email is not registered' && $valid_login != null) {
                $item['message'] = 'The user is valid.';
                $item['valid_login'] = true;
                $item['data'] = $valid_login;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } else if ($valid_login != 'The email is not registered') {
                $item['message'] = 'All password or email is incorrect.';
                $item['valid_login'] = false;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $item['message'] = 'Email is not registered.';
                $item['valid_login'] = false;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
