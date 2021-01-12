<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('user_model');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['login_post']['limit'] = 500;
        $this->methods['register_post']['limit'] = 500;
        $this->methods['index_get']['limit'] = 500; 
    }

    function index_get($id){
        if($id){
            $details['field_name'] = 'user_id';
            $details['value'] = $id;
            $result = $this->user_model->get_user($details);
            if($result){
                $result['user_password'] = '';
                $item['message'] = 'The user exists.';
                $item['retrieved'] = true;
                $item['data'] = $result;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }else{
                $data['message'] = 'The user does not exist.';
                $data['retrieved'] = false;
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }else {
            $data['message'] = 'The user id has not been given.';
            $data['retrieved'] = false;
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    function login_post()
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
                // $details['user_email'] = $valid_login['user_email'];
                // $details['user_fname'] = $valid_login['user_fname'];
                // $details['user_lname'] = $valid_login['user_lname'];
                // $details['wishlist_name'] = $valid_login['wishlist_name'];
                // $details['wishlist_description'] = $valid_login['wishlist_description'];
                // $details['wishlist_occasion'] =$valid_login['wishlist_occasion'];
                $valid_login['user_password'] = '';
                $item['data'] = $valid_login;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
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

    public function register_post()
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
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } // CREATED (201) being the HTTP response code}
            else {
                $item['message'] = 'Cannot register user as email is already in use.';
                $item['registered'] = false;
                $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
