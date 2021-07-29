<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends Render_Controller
{
    public function index()
    {
        // Page Settings
        $this->title                    = 'Pengaturan Laporan';
        $this->content                  = 'pengaturan-laporan';
        $this->navigation               = ['Pengaturan', 'Laporan   '];
        $this->plugins                  = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1             = 'Dashboard';
        $this->breadcrumb_1_url         = base_url() . 'dashboard';
        $this->breadcrumb_2             = 'Pengaturan';
        $this->breadcrumb_2_url         = '#';
        $this->breadcrumb_3             = 'Laporan';
        $this->breadcrumb_3_url         = '#';
        $this->render();
        
    }

    public function getData()
    {
        $this->output_json($this->laporan->getData());
    }

    public function setData()
    {
        $kepala_sekolah = $this->input->post("kepala_sekolah");
        $nip_kepala_sekolah = $this->input->post("nip_kepala_sekolah");
        $pemegang_kas = $this->input->post("pemegang_kas");
        $nip_pemegang_kas = $this->input->post("nip_pemegang_kas");
        $kota = $this->input->post("kota");
        $this->output_json($this->laporan->setData($kepala_sekolah, $nip_kepala_sekolah, $pemegang_kas, $nip_pemegang_kas, $kota));
    }

    function __construct()
    {
        parent::__construct();
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
        $this->load->model('pengaturan/LaporanModel', 'laporan');

        // Cek session
        $this->sesion->cek_session();
    }
}
