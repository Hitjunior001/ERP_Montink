<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Variation_model');
        $this->load->model('Variation_option_model');
        $this->load->model('Product_variation_model');
        $this->load->model('Stock_variation_model');
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    public function index()
    {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('layout/header', $data);
        $this->load->view('products/index', $data);
        $this->load->view('layout/footer');
    }

    public function insert_product()
    {
        if ($this->input->method() === 'post') {
            $product_data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price')
            ];

            $this->Product_model->insert($product_data);

            redirect('index.php/products');
        } else {
            $this->load->view('layout/header');
            $this->load->view('products/form_product');
            $this->load->view('layout/footer');
        }
    }

    public function update_product($product_id)
    {
        $product = $this->Product_model->get($product_id);

        if (!$product) {
            echo "Produto não encontrado";
        }

        if ($this->input->post()) {
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
            ];

            $this->Product_model->update($product_id, $data);

            redirect('index.php/products');
        }

        $data['product'] = $product;

        $this->load->view('layout/header');
        $this->load->view('products/form_product', $data);
        $this->load->view('layout/footer');
    }


    public function update_product_variation($product_variation_id)
    {
        if ($this->input->post()) {
            $variation_id = $this->input->post('variation_id');
            $new_variation = $this->input->post('new_variation');
            $option_id = $this->input->post('variation_option_id');
            $new_option = $this->input->post('new_variation_option');
            $quantity = $this->input->post('quantity');

            if ($new_variation) {
                $variation_id = $this->Variation_model->insert(['name' => $new_variation]);
            }

            if ($new_option) {
                $option_id = $this->Variation_option_model->insert([
                    'variation_id' => $variation_id,
                    'name' => $new_option
                ]);
            }
        $data = [
            'variation_option_id' => $this->input->post('variation_option_id'),
            'quantity' => $this->input->post('quantity')
        ];

        $this->Product_variation_model->update($product_variation_id, $data);
            redirect('index.php/variations');
        }

        $data['product_variation'] = $this->Product_variation_model->get_with_details($product_variation_id);

        if (!$data['product_variation']) {
            echo "Variação de produto não encontrada";
        }

        $data['variations'] = $this->Variation_model->get_all();
        $data['options'] = $this->Variation_option_model->get_all();

        $this->load->view('layout/header');
        $this->load->view('products/form_product_variation', $data);
        $this->load->view('layout/footer');
    }



    public function insert_product_variation()
    {

        $data['products'] = $this->Product_model->get_all();
        $data['variations'] = $this->Variation_model->get_all();
        $data['options'] = $this->Variation_option_model->get_all();



        if ($this->input->method() === 'post') {


            $product_id = $this->input->post('product_id');

            $variation_id = $this->input->post('variation_id');
            $new_variation = trim($this->input->post('new_variation'));

            if (!$variation_id && !empty($new_variation)) {
                $variation_id = $this->Variation_model->insert(['name' => $new_variation]);
            }

            $variation_option_id = $this->input->post('variation_option_id');
            $new_variation_option = trim($this->input->post('new_variation_option'));

            if (!$variation_option_id && !empty($new_variation_option) && $variation_id) {
                $variation_option_id = $this->Variation_option_model->insert([
                    'variation_id' => $variation_id,
                    'name' => $new_variation_option
                ]);
            }

            if ($variation_option_id && $product_id) {
                $product_variation_id = $this->Product_variation_model->insert([
                    'product_id' => $product_id,
                    'variation_option_id' => $variation_option_id
                ]);

                $this->Stock_variation_model->insert([
                    'product_variation_id' => $product_variation_id,
                    'quantity' => $this->input->post('quantity')
                ]);
            }

            redirect('index.php/products');
        } else {
            $this->load->view('layout/header');
            $this->load->view('products/form_product_variation', $data);
            $this->load->view('layout/footer');

        }
    }

}
