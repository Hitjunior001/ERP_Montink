<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    public function get_all()
    {
        return $this->db->get('coupons')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('coupons', $data);
    }

    public function get_by_code($code)
    {
        return $this->db->get_where('coupons', ['code' => $code])->row();
    }
}
