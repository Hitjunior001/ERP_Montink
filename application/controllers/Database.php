<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Controller {

    public function index()
    {
        if ($this->load->database()) {
            echo "Conexão com o banco de dados realizada com sucesso.";
        } else {
            echo "Falha ao conectar no banco de dados.";
        }
    }
}