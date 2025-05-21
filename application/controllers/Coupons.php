<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Coupons extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Coupon_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['coupons'] = $this->Coupon_model->get_all();

        $this->form_validation->set_rules('code', 'Código', 'required|is_unique[coupons.code]');
        $this->form_validation->set_rules('discount_value', 'Valor do Desconto', 'required|decimal');
        $this->form_validation->set_rules('valid_from', 'Data Inicial', 'required');
        $this->form_validation->set_rules('valid_until', 'Data Final', 'required');
        $this->form_validation->set_rules('active', 'Ativo', 'required');

        if ($this->form_validation->run() === TRUE) {
            $data_to_insert = [
                'code' => $this->input->post('code'),
                'discount_value' => $this->input->post('discount_value'),
                'valid_from' => $this->input->post('valid_from'),
                'valid_until' => $this->input->post('valid_until'),
                'active' => $this->input->post('active'),
            ];
            $this->Coupon_model->insert($data_to_insert);
            redirect('index.php/coupons');
        }

        $this->load->view('layout/header');
        $this->load->view('coupons/index', $data);
        $this->load->view('layout/footer');
    }

    public function validate_coupon()
    {
        header('Content-Type: application/json');
        $code = $this->input->post('code');

        $coupon = $this->Coupon_model->get_by_code($code);

        $today = date('Y-m-d');

        if (!$coupon) {
            echo json_encode(['valid' => false, 'message' => 'Cupom inválido']);
            return;
        }

        if (!$coupon->active) {
            echo json_encode(['valid' => false, 'message' => 'Cupom inativo']);
            return;
        }

        if ($coupon->valid_from > $today || $coupon->valid_until < $today) {
            echo json_encode(['valid' => false, 'message' => 'Cupom expirado ou ainda não válido']);
            return;
        }

        echo json_encode([
            'valid' => true,
            'discount_value' => $coupon->discount_value,
            'message' => 'Cupom válido!'
        ]);
    }
}
