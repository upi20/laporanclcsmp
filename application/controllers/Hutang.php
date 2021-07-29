<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Hutang';
		$this->content 					= 'hutang';
		$this->navigation 				= ['Hutang'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'hutang';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->render();
	}


	// Ajax Data
	public function ajax_data()
	{
		$status 	= $this->input->post('status');
		$start 		= $this->input->post('start');
		$draw 		= $this->input->post('draw');
		$length 	= $this->input->post('length');
		$cari 		= $this->input->post('search');
		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		$data 	= $this->hutang->getAllData($length, $start, $_cari, $status, $this->id_cabang)->result_array();
		$count 	= count($data);

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->hutang->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'nama'	 				=> $exe['nama'],
				'no_hp'				 	=> $exe['no_hp'],
				'keterangan'		 	=> $exe['keterangan'],
				'jumlah'			 	=> $exe['jumlah'],
				'dibayar'			 	=> $exe['dibayar'],
				'sisa'				 	=> $exe['sisa'],
				'status' 				=> $exe['status'],
				'tanggal' 				=> $exe['tanggal'],
			]
		);
	}

	// Insert data
	public function bayar()
	{
		$get_cabang 				= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$id_cabang 					= $get_cabang['id'];

		// ubah tanggal administrasi dulu
		$tanggal = $this->input->post("tanggal_administrasi");
		$exe 						= $this->hutang->update_tanggal_administrasi($id_cabang, $tanggal);

		// eksekusi hutang

		$dibayar 					= $this->input->post('dibayar');

		$exe 						= $this->hutang->bayar($id_cabang, $dibayar);
		$this->output_json(
			[
				'dibayar' 			=> $dibayar
			]
		);
	}

	// Insert data
	public function insert()
	{
		$get_cabang 				= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$id_cabang 					= $get_cabang['id'];

		$nama 						= $this->input->post('nama');
		$no_hp 						= $this->input->post('no_hp');
		$keterangan 				= $this->input->post('keterangan');
		$jumlah 					= $this->input->post('jumlah');
		$dibayar 					= 0;
		$sisa 						= $jumlah;
		$status 					= 0;
		$tanggal 					= $this->input->post('tanggal');

		$exe 						= $this->hutang->insert($id_cabang, $nama, $no_hp, $keterangan, $jumlah, $dibayar, $sisa, $status, $tanggal);
		$this->output_json(
			[
				'nama' 				=> $nama,
				'no_hp' 			=> $no_hp,
				'keterangan' 		=> $keterangan,
				'jumlah' 			=> $jumlah,
				'dibayar' 			=> $dibayar,
				'sisa' 				=> $sisa,
				'status' 			=> $status,
				'tanggal' 			=> $tanggal,
			]
		);
	}


	// Update data
	public function update()
	{
		$get_cabang 				= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$id_cabang 					= $get_cabang['id'];

		$id 						= $this->input->post('id');
		$nama 						= $this->input->post('nama');
		$no_hp 						= $this->input->post('no_hp');
		$keterangan 				= $this->input->post('keterangan');
		$jumlah 					= $this->input->post('jumlah');
		$dibayar 					= 0;
		$sisa 						= $jumlah;
		$status 					= 0;
		$tanggal 					= $this->input->post('tanggal');

		$exe 						= $this->hutang->update($id, $id_cabang, $nama, $no_hp, $keterangan, $jumlah, $dibayar, $sisa, $status, $tanggal);

		$this->output_json(
			[
				'id' 				=> $id,
				'nama' 				=> $nama,
				'no_hp' 			=> $no_hp,
				'keterangan' 		=> $keterangan,
				'jumlah' 			=> $jumlah,
				'dibayar' 			=> $dibayar,
				'sisa' 				=> $sisa,
				'status' 			=> $status,
				'tanggal' 			=> $tanggal,
			]
		);
	}


	// Delete data
	public function delete()
	{

		$id 							= $this->input->post('id');

		$exe 							= $this->hutang->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getSaldo()
	{
		$get_cabang 			= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$id_cabang 				= $get_cabang['id'];
		$get 					= $this->db->get_where('saldos', ['id_cabang' => $id_cabang])->row_array();

		$this->output_json(
			[
				'jumlah_ringgit' 			=> $get['total_ringgit'],
				'jumlah_rupiah' 			=> $get['total_rupiah']
			]
		);
	}

	public function getTotalHutang()
	{
		$get_cabang 			= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$id_cabang 				= $get_cabang['id'];
		$get 					= $this->db->select_sum('sisa')->get_where('hutang', ['id_cabang' => $id_cabang, 'status' => 0])->row_array();

		$this->output_json(
			[
				'sisa' 			=> $get['sisa'],
			]
		);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('hutangModel', 'hutang');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');
		$get_cabang 			= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$this->id_cabang 				= $get_cabang['id'];
		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */