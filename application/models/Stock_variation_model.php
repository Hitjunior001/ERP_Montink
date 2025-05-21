<?php
class Stock_variation_model extends CI_Model {

    protected $table = 'stock_variations';

    public function get_by_combination($product_variation_id) {
        return $this->db->get_where($this->table, ['product_variation_id' => $product_variation_id])->row();
    }

    public function update_quantity($product_variation_id, $quantity) {
        $this->db->where('product_variation_id', $product_variation_id);
        return $this->db->update($this->table, ['quantity' => $quantity]);
    }

    public function insert($data) {
        return $this->db->insert('stock_variations', $data);
    }
public function get_all_with_details()
{
    $this->db->select('
        pv.product_variation_id,
        p.name AS product_name,
        vo.name AS option_name,
        v.name AS variation_name,
        sv.quantity as quantity
    ');
    $this->db->from('product_variations pv');
    $this->db->join('products p', 'pv.product_id = p.product_id');
    $this->db->join('variation_options vo', 'pv.variation_option_id = vo.variation_option_id');
    $this->db->join('variations v', 'vo.variation_id = v.variation_id');
    $this->db->join('stock_variations sv', 'sv.product_variation_id = pv.product_variation_id');

    
    return $this->db->get()->result();
}




}
