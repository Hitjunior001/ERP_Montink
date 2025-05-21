<?php
class Variation_option_model extends CI_Model {

    protected $table = 'variation_options';

public function insert($data) {
    $this->db->insert('variation_options', $data);
    return $this->db->insert_id(); 
}


    public function get($variation_option_id) {
        return $this->db->get_where($this->table, ['variation_option_id' => $variation_option_id])->row();
    }

    public function get_all() {
        return $this->db->get('variation_options')->result();
    }
}
