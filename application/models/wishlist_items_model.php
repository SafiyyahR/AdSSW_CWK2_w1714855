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
    }


    function get_item($data)
    {
        $this->wli_id = $data['id'];
        $query = $this->db->select()
            ->where('wli_id', $this->wli_id)
            ->get('wishlist_items');
        return ($query->row_array());
    }

    function insert_item($data)
    {
        $this->wli_id = $data['id'];
        $query = $this->db->select()
            ->where('wli_id', $this->wli_id)
            ->get('wishlist_items');
        return ($query->row_array());
    }

}
