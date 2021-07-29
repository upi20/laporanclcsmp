<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Periode extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Pengaturan - Periode';
		$this->content 					= 'pengaturan-periode';
		$this->navigation 				= ['Periode'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Pengaturan';
		$this->breadcrumb_2_url 		= '#';
		$this->breadcrumb_3 			= 'periode';
		$this->breadcrumb_3_url 		= base_url() . 'pengaturan/periode';

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
		$data 	= $this->periode->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->periode->getAllData(null, null, $_cari, $status)->num_rows();

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}

	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->periode->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'tahun_awal' 			=> $exe['tahun_awal'],
				'tahun_akhir' 			=> $exe['tahun_akhir'],
				'status' 				=> $exe['status'],
			]
		);
	}

	// Insert data
	public function insert()
	{
		$tahun_awal 						= $this->input->post('tahun_awal');
		$tahun_akhir 						= $this->input->post('tahun_akhir');
		$status                             = $this->input->post('status');
		$exe 							    = $this->periode->insert($tahun_awal, $tahun_akhir, $status);
		$this->output_json(
			[
				'id' 				    => $exe['id'],
				'tahun_awal' 			=> $tahun_awal,
				'tahun_akhir' 			=> $tahun_akhir,
				'status' 			    => $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$tahun_awal 					= $this->input->post('tahun_awal');
		$tahun_akhir 					= $this->input->post('tahun_akhir');
		$status 						= $this->input->post('status');

		$exe 							= $this->periode->update($id, $tahun_awal, $tahun_akhir, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'tahun_awal' 			=> $tahun_awal,
				'tahun_akhir' 			=> $tahun_akhir,
				'status' 			    => $status,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->periode->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('pengaturan/Modelperiode', 'periode');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/periode.php */