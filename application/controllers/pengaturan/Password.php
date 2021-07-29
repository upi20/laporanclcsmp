<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password extends Render_Controller
{
    public function index()
    {
        // Page Settings
        $this->title                    = 'Ganti Password';
        $this->content                  = 'pengaturan-password-cabang';
        $this->navigation               = ['Ganti Password'];

        // Breadcrumb setting
        $this->breadcrumb_1             = 'Dashboard';
        $this->breadcrumb_1_url         = base_url() . 'dashboard';
        $this->breadcrumb_2             = 'Ganti Password';
        $this->breadcrumb_2_url         = '#';

        $this->render();
    }

    // cek current password
    public function cek_password()
    {
        $id_cabang = $this->input->post("id_cabang");
        $id_cabang = ($id_cabang == null) ? $this->id_cabang : $id_cabang;
        $current_password = $this->input->post("current_password");
        $result = $this->password->cekPpassword($id_cabang, $current_password);
        $this->output_json($result);
    }

    // update
    public function update_password()
    {
        $id_cabang = $this->input->post("id_cabang");
        $id_cabang = ($id_cabang == null) ? $this->id_cabang : $id_cabang;
        $new_password = $this->input->post("new_password");
        $result = $this->password->updatePassword($id_cabang, $new_password);
        $this->output_json($result);
    }

    function __construct()
    {
        parent::__construct();
        $this->sesion->cek_session();
        $this->default_template = 'templates/dashboard';
        $this->load->model("pengaturan/PasswordModel", 'password');
        $this->load->helper('url');
        $this->cabangdetail = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
        $this->id_cabang = $this->cabangdetail['id'];
    }
}
