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
        $details['field_name'] = 'user_id';
        $details['value'] = $data['user_id'];
        if ($this->user_model->has_registered($details)) {
            $query = $this->db->select()
                ->where('wli_user_id', $this->wli_user_id)
                ->get('wishlist_items')
                ->orderby("wli_priority ASC, wli_title ASC");
            $data['results'] = $query;
            $data['registered']  = true;
            return $data;
        } else {
            $data['registered'] = false;
        }
    }

    function get_item($id)
    {
        $query = $this->db->select('*')
            ->where('wli_id', $id)
            ->get('wishlist_items');
        if ($query->num_rows() > 0) {
            return $query->row_array();;
        } else {
            return null;
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
        $this->db->update('wishlist_items', $data);
    }
}
