<?php
class Variation_model extends CI_Model {

    public function insert($data) {
        $this->db->insert('variations', $data);
        return $this->db->insert_id(); 
    }

    public function get_all() {
        return $this->db->get('variations')->result();
    }
    public function get($variation_Id) {
        return $this->db->get_where('variations', ['variation_Id' => $variation_Id])->row();
    }
}
