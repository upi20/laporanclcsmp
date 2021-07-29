<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportHasil extends Render_Controller {



	public function index()
	{
		// Page Settings
		$this->title 					= 'Export Hasil';
		$this->content 					= 'export-hasil';
		$this->navigation 				= ['Export Hasil'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Export Hasil';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->data['jadwal'] 			= $this->db->select('a.*, b.token, c.nama as mapel, d.nama as kota')
		->from('jadwal a')
		->join('soal b', 'b.id = a.id_soal')
		->join('mata_pelajaran c', 'c.id = b.id_mata_pelajaran')
		->join('kota_kab d', 'd.id = a.kota_kab')
		->where('a.status', 1)
		->get()->result_array();

		$this->render();
	}

	public function excel($id)
	{
		$sekolah 					= $this->db->get_where('sekolah', ['id_user' => $this->session->userdata('data')['id']])->row_array();

		$data['record'] 			= $this->db->select('f.nama,f.id,d.token,e.nama as mapel,a.mulai,a.lama_pengerjaan,a.status,a.id as idjawaban,b.user_id,b.user_nama')->from('siswa f')
		->join('jawaban a', 'a.id_siswa = f.id_user', 'left')
		->join('users b','b.user_id = a.id_siswa', 'left')
		->join('jadwal c','c.id = a.id_jadwal', 'left')
		->join('soal d','d.id = c.id_soal', 'left')
		->join('mata_pelajaran e','d.id_mata_pelajaran = e.id', 'left')
		->where('c.id', $id)
		// ->where('f.id_sekolah', $sekolah['id'])
		->order_by('a.mulai', 'asc')
		->get();
		$data['detail'] 			= function($id)
		{
			return $this->db->select('jawaban_pilihan_ganda')->get_where('jawaban_detail', ['id_jawaban' => $id]);	
		};
		$this->load->view('templates/eksport-hasil', $data);
	}

	function __construct()
	{
		parent::__construct();
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}


}

/* End of file ExportHasil.php */
/* Location: ./application/controllers/ExportHasil.php */