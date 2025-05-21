<?php
class Order_model extends CI_Model {

    protected $table = 'orders';

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_customer($customer_id) {
        return $this->db->get_where($this->table, ['customer_id' => $customer_id])->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['order_id' => $id])->row();
    }
}
