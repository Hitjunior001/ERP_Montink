<?php
class Product_variation_model extends CI_Model {

    protected $table = 'product_variations';

    public function insert($data) {
        $this->db->insert('product_variations', $data);
        return $this->db->insert_id(); 
    }

    public function get_by_product($product_id) {
        return $this->db->get_where($this->table, ['product_id' => $product_id])->result();
    }

    public function get($product_variation_id) {
        return $this->db->get_where($this->table, ['product_variation_id' => $product_variation_id])->row();
    }
    public function update($product_variation_id, $data)
    {
        $product_variation_data = [
            'variation_option_id' => $data['variation_option_id'],
        ];

        $stock_variation_data = [
            'quantity' => $data['quantity']
        ];

        $this->db->where('product_variation_id', $product_variation_id);
        $this->db->update('product_variations', $product_variation_data);

        $this->db->where('product_variation_id', $product_variation_id);
        $this->db->update('stock_variations', $stock_variation_data);
    }

    public function get_with_details($product_variation_id)
    {
        $this->db->select('
            pv.product_id,
            p.name,
            pv.product_variation_id,
            pv.variation_option_id,
            vo.variation_id,
            sv.quantity
        ');
        $this->db->from('product_variations pv');
        $this->db->join('variation_options vo', 'pv.variation_option_id = vo.variation_option_id');
        $this->db->join('products p', 'p.product_id = pv.product_id');
        $this->db->join('stock_variations sv', 'sv.product_variation_id = pv.product_variation_id');
        $this->db->where('pv.product_variation_id', $product_variation_id);

        return $this->db->get()->row(); 
    }


}
