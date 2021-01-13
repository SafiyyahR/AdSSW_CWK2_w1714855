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

    function item_post()
    {
        $data['wli_user_id'] = $this->input->post('wli_user_id');

        $data['wli_title'] = $this->input->post('wli_title');

        $data['wli_url'] = $this->input->post('wli_url');

        $data['wli_price'] = $this->input->post('wli_price');

        $data['wli_priority'] = $this->input->post('wli_priority');
        $this->wishlist_items_model->insert_record($data);
        $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
    }


    function item_delete()
    {
        if ($this->input->post('wli_id')) {
            $this->wishlist_items_model->delete_item($this->input->post('wli_id'));
            $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    function item_get($item_id)
    {
        if ($item_id) {
            $result = $this->wishlist_items_model->get_item($item_id);
            if ($result) {
                $this->set_response($result, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function items_get($user_id)
    {
        if ($user_id) {
            $param['user_id'] = intval($user_id);
            $result = $this->wishlist_items_model->get_wishlist($param);
            if ($result['registered']) {
                $this->set_response($result['results'], \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } else {
            $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function item_put()
    {
        $data['wli_user_id'] = $this->input->post('wli_user_id');

        $data['wli_title'] = $this->input->post('wli_title');

        $data['wli_url'] = $this->input->post('wli_url');

        $data['wli_price'] = $this->input->post('wli_price');

        $data['wli_priority'] = $this->input->post('wli_priority');

        $this->wishlist_items_model->update_item($data);

        $this->set_response('ok', \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
