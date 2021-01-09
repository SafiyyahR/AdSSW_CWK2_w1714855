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

    function user_post()
    {
        if ($this->input->post('user_email')) {
            $data['user_email'] = $this->input->post('user_email');
        } else {
            $message['user_email'] = 'Email is a required field.';
        }
        if ($this->input->post('user_password')) {
            $data['user_password'] = $this->input->post('user_password');
        } else {
            $message['user_password'] = 'Password is a required field.';
        }
        if (sizeof($message) > 0) {
            $data['message'] = 'All the fields have not been filled.';
            $data['valid_login'] = false;
            $data['data'] = $message;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }else{
            $valid_login = $this->user_model->validate_credentials($data);
            if ($valid_login != 'The email is not registered' && $valid_login != null) {
                $data['message'] = 'The user is valid.';
                $data['valid_login'] = true;
                $data['data'] = $valid_login;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } else if ($valid_login != 'The email is not registered') {
                $data['message'] = 'All password or email is incorrect.';
                $data['valid_login'] = false;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $data['message'] = 'Email is not registered.';
                $data['valid_login'] = false;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
