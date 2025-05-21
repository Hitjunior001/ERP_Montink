<?php
class order_product_variation_model extends CI_Model {

    protected $table = 'order_product_variation';

    public function insert_batch($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    public function get_by_order($order_id) {
        return $this->db->get_where($this->table, ['order_id' => $order_id])->result();
    }
}
