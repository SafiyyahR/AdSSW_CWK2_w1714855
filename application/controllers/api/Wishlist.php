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
        parent::__construct();
        $this->load->model('wishlist_items_model');
        $this->methods['item_post']['limit'] = 500;
    }

    function items_post()
    {
        if (count($this->input->post()) > 0) {
            $data['wli_user_id'] = $this->input->post('wli_user_id');

            $data['wli_title'] = $this->input->post('wli_title');

            $data['wli_url'] = $this->input->post('wli_url');

            $data['wli_price'] = $this->input->post('wli_price');

            $data['wli_priority'] = $this->input->post('wli_priority');
        } else {
            $in = file_get_contents('php://input');
            $decoded = json_decode($in, true);
            $data['wli_user_id'] = $decoded['wli_user_id'];
            $data['wli_title'] = $decoded['wli_title'];
            $data['wli_url'] = $decoded['wli_url'];
            $data['wli_price'] = $decoded['wli_price'];
            $data['wli_priority'] = $decoded['wli_priority'];
        }
        $this->wishlist_items_model->insert_item($data);
        $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
    }


    function item_delete($item_id)
    {
        if ($item_id) {
            $this->wishlist_items_model->delete_item($item_id);
            $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function item_get($item_id)
    {
        if ($item_id) {
            $result = $this->wishlist_items_model->get_item($item_id);
            if ($result) {
                $this->set_response($result, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function items_get($user_id)
    {
        if ($user_id) {
            $result = $this->wishlist_items_model->get_wishlist(intval($user_id));
            if ($result) {
                $this->set_response($result, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->set_response($result, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function item_post()
    {
        if (count($this->input->post()) > 0) {
            $data['wli_id'] = $this->input->post('wli_id');
            $data['wli_user_id'] = $this->input->post('wli_user_id');
            $data['wli_title'] = $this->input->post('wli_title');
            $data['wli_url'] = $this->input->post('wli_url');
            $data['wli_price'] = $this->input->post('wli_price');
            $data['wli_priority'] = $this->input->post('wli_priority');
        } else {
            $in = file_get_contents('php://input');
            $decoded = json_decode($in, true);
            $data['wli_id'] = $decoded['wli_id'];
            $data['wli_user_id'] = $decoded['wli_user_id'];
            $data['wli_title'] = $decoded['wli_title'];
            $data['wli_url'] = $decoded['wli_url'];
            $data['wli_price'] = $decoded['wli_price'];
            $data['wli_priority'] = $decoded['wli_priority'];
        }

        $this->wishlist_items_model->update_item($data);

        $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
