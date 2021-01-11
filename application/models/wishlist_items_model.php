<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Wishlist_items_model extends CI_Model
{
    public $wli_id;
    public $wli_user_id;
    public $wli_title;
    public $wli_url;
    public $wli_price;
    public $wli_priority;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');        
        $this->load->dbutil();
        $this->db->query('use w1714855_0');
    }


    function get_wishlist($data)
    {
        $this->wli_user_id = $data['user_id'];
        if ($this->user_model->has_registered_id($data['user_id'])) {
            $query = $this->db->select()
                ->where('wli_user_id', $this->wli_user_id)
                ->get('wishlist_items');
                $data['results']=$query;
                $data['registered']  = true;
            return $data;
        
        }else{
            $data['registered'] = false;
        }
    }

    function insert_item($data)
    {

        $this->db->insert('wishlist_items', $data);
    }

    function delete_item($data)
    {
        $this->db->where('wli_id', $data['wli_id']);
        $this->db->delete('wishlist_items');
    }

    function update_item($data)
    {
        $this->db->where('wli_id', $data['wli_id']);
        $this->db->update('wishlist_items', array($data['field_name'] => $data['value']));
    }
}
