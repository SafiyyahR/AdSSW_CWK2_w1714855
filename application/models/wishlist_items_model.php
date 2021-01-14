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
        $this->wli_user_id = $data;
        $details['field_name'] = 'user_id';
        $details['value'] = $data;
        if ($this->user_model->has_registered($details)) {
            $this->db->select('*');
            $this->db->from('wishlist_items');
            $this->db->where('wli_user_id', $data);
            $this->db->order_by('wli_priority ASC, wli_title ASC');
            $query = $this->db->get();
            $results = [];
            $i = 0;
            foreach ($query->result() as $row) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        } else {
            return null;
        }
    }

    function get_item($id)
    {
        $this->db->select('*');
        $this->db->from('wishlist_items');
        $this->db->where('wli_id', $id);
        $query = $this->db->get();
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
        $this->db->where('wli_id', $data);
        $this->db->delete('wishlist_items');
    }

    function update_item($data)
    {
        $this->db->where('wli_id', $data['wli_id']);
        return $this->db->update('wishlist_items', $data);
    }
}
