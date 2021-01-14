<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->methods['login_post']['limit'] = 500;
        $this->methods['register_post']['limit'] = 500;
        $this->methods['index_get']['limit'] = 500;
    }

    function index_get($id)
    {
        if ($id) {
            $details['field_name'] = 'username';
            $details['value'] = $id;
            $result = $this->user_model->get_user($details);
            if ($result) {
                $result['user_password'] = '';
                $this->set_response($result, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
    function login_post()
    {

        if (count($this->input->post()) > 0) {
            $data['username'] = $this->input->post('username');
            $data['user_password'] = $this->input->post('user_password');
        } else {
            $in = file_get_contents('php://input');
            $decoded = json_decode($in, true);
            $data['username'] = $decoded['username'];
            $data['user_password'] = $decoded['user_password'];
        }
        $valid_login = $this->user_model->validate_credentials($data);
        if ($valid_login != 'The username is not registered' && $valid_login != null) {
            $item['message'] = 'The user is valid.';
            $item['valid_login'] = true;
            $valid_login['user_password'] = '';
            $item['data'] = $valid_login;
            $this->set_response($valid_login, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register_post()
    {
        if (count($this->input->post()) > 0) {
            $data['username'] = $this->input->post('username');
            $data['user_fname'] = $this->input->post('user_fname');
            $data['user_lname'] = $this->input->post('user_lname');
            $data['user_password'] = $this->input->post('user_password');
            $data['wishlist_name'] = $this->input->post('wishlist_name');
            $data['wishlist_description'] = $this->input->post('wishlist_description');
            $data['wishlist_occasion'] = $this->input->post('wishlist_occasion');
        } else {
            $in = file_get_contents('php://input');
            $decoded = json_decode($in, true);
            $data['username'] = $decoded['username'];
            $data['user_fname'] = $decoded['user_fname'];
            $data['user_lname'] = $decoded['user_lname'];
            $data['user_password'] = $decoded['user_password'];
            $data['wishlist_name'] = $decoded['wishlist_name'];
            $data['wishlist_description'] = $decoded['wishlist_description'];
            $data['wishlist_occasion'] = $decoded['wishlist_occasion'];
        }

        if ($this->user_model->insert_record($data) === 'Registered New User') {
            $item['message'] = 'New User has been registered.';
            $item['registered'] = true;
            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
}
