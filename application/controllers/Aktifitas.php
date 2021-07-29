<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktifitas extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Aktifitas Utama';
		$this->content 					= 'rab-aktifitas';
		$this->navigation 				= ['Aktifitas Utama'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Aktifitas Utama';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->render();
	}


	// Ajax Data
	public function ajax_data()
	{
		$status 	= $this->input->post('status');
		$start 	= $this->input->post('start');
		$draw 	= $this->input->post('draw');
		$length = $this->input->post('length');
		$cari 	= $this->input->post('search');
		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		$data 	= $this->kurs->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->kurs->getAllData(null, null, $_cari, $status)->num_rows();

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kota->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'jenis_kota' 			=> $exe['jenis_kota'],
				'id_mata_pelajaran' 	=> $exe['id_mata_pelajaran'],
				'model' 				=> $exe['model'],
				'status' 				=> $exe['status'],
			]
		);
	}


	// Insert data
	public function insert()
	{
		$jenis_kota 					= $this->input->post('jenis_kota');
		$id_mata_pelajaran 				= $this->input->post('id_mata_pelajaran');
		$model 							= $this->input->post('model');
		$status 						= $this->input->post('status');

		$exe 							= $this->kota->insert($jenis_kota, $id_mata_pelajaran, $model, $status);
		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'token' 			=> $exe['token'],
				'jenis_kota' 		=> $jenis_kota,
				'id_mata_pelajaran' => $id_mata_pelajaran,
				'nama' 				=> $exe['nama'],
				'model' 			=> $model,
				'jumlah' 			=> $exe['jumlah'],
				'tanggal' 			=> $exe['tanggal'],
				'status' 			=> $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$jenis_kota 					= $this->input->post('jenis_kota');
		$id_mata_pelajaran 				= $this->input->post('id_mata_pelajaran');
		$model 							= $this->input->post('model');
		$status 						= $this->input->post('status');

		$exe 							= $this->kota->update($id, $jenis_kota, $id_mata_pelajaran, $model, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'token' 			=> $exe['token'],
				'jenis_kota' 		=> $jenis_kota,
				'id_mata_pelajaran' => $id_mata_pelajaran,
				'nama' 				=> $exe['nama'],
				'model' 			=> $model,
				'jumlah' 			=> $exe['jumlah'],
				'tanggal' 			=> $exe['tanggal'],
				'status' 			=> $status,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kota->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getMataPelajaran()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kota->getMataPelajaran($id);

		$this->output_json($exe);
	}


	function __construct()
	{
		parent::__construct();
		// $this->load->model('kotaModel', 'kota');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */