<?php
class Product_model extends CI_Model {

    public function insert($data) {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function update($product_id, $data) {
        $this->db->where('product_id', $product_id);
        return $this->db->update('products', $data);
    }

    public function insert_stock($product_id, $variation, $quantity) {
        $this->db->insert('stock', [
            'product_id' => $product_id,
            'variation' => $variation,
            'quantity' => $quantity
        ]);
    }

    public function update_stock($product_id, $variation, $quantity) {
        $this->db->where('product_id', $product_id);
        $this->db->update('stock', [
            'variation' => $variation,
            'quantity' => $quantity
        ]);
    }

    public function get_all() {
        return $this->db->get('products')->result();
    }

    public function get($product_id) {
        return $this->db->get_where('products', ['product_id' => $product_id])->row();
    }

    public function get_all_products_with_variations($product_id) {
        $this->db->select('
            p.product_id,
            SUM(sv.quantity) as total_quantity
        ');
        $this->db->from('products p');
        $this->db->join('product_variations pv', 'pv.product_id = p.product_id', 'left');
        $this->db->join('stock_variations sv', 'sv.product_variation_id = pv.product_variation_id', 'left');
        $this->db->where('p.product_id', $product_id);
        $this->db->group_by('p.product_id');
        return $this->db->get()->row();
    }
}
