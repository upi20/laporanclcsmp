<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rab extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'RAB';
		$this->content 					= 'pengaturan-rab';
		$this->navigation 				= ['Pengaturan', 'RAB '];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Rab';
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
		$data 	= $this->rab->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->rab->getAllData(null, null, $_cari, $status)->num_rows();

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->rab->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'keterangan' 			=> $exe['keterangan'],
				'tanggal_mulai'			=> $exe['tanggal_mulai'],
				'tanggal_akhir' 		=> $exe['tanggal_akhir'],
				'status' 				=> $exe['status'],
			]
		);
	}


	// Insert data
	public function insert()
	{
		$keterangan 						= $this->input->post('keterangan');
		$tanggal_mulai 						= $this->input->post('tanggal_mulai');
		$tanggal_akhir 						= $this->input->post('tanggal_akhir');
		$status 							= $this->input->post('status');

		$exe 							= $this->rab->insert($keterangan, $tanggal_mulai, $tanggal_akhir, $status);
		$this->output_json(
			[
				'keterangan' 			=> $keterangan,
				'tanggal_mulai' 		=> $tanggal_mulai,
				'tanggal_akhir' 		=> $tanggal_akhir,
				'status' 				=> $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$keterangan 					= $this->input->post('keterangan');
		$tanggal_mulai 	 				= $this->input->post('tanggal_mulai');
		$tanggal_akhir 					= $this->input->post('tanggal_akhir');
		$status 						= $this->input->post('status');

		$exe 							= $this->rab->update($id, $keterangan, $tanggal_mulai, $tanggal_akhir, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'keterangan' 		=> $keterangan,
				'tanggal_mulai' 	=> $tanggal_mulai,
				'tanggal_akhir' 	=> $tanggal_akhir,
				'status' 			=> $status,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->rab->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getMataPelajaran()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kurs->getMataPelajaran($id);

		$this->output_json($exe);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('pengaturan/rabModel', 'rab');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */