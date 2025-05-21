<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Variations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Variation_model');
        $this->load->model('Stock_variation_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index()
    {
        $product_variations = $this->Stock_variation_model->get_all_with_details();

        $data['product_variations'] = $product_variations;

        $this->load->view('layout/header');
        $this->load->view('variations/index', $data);
        $this->load->view('layout/footer');
    }

    public function create() {
        $this->form_validation->set_rules('name', 'Nome da Variação', 'required|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layout/header');
            $this->load->view('variations/create');
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
            );

            $this->Variation_model->insert($data);

            redirect('index.php/variations/index');
        }
    }
}
