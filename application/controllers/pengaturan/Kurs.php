<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kurs extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Kurs';
		$this->content 					= 'pengaturan-kurs';
		$this->navigation 				= ['Kurs'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'kurs';
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
		$data 	= $this->kurs->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->kurs->getAllData(null, null, $_cari, $status)->num_rows();

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kurs->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'ringgit' 				=> $exe['ringgit'],
				'rupiah'			 	=> $exe['rupiah'],
				'status' 				=> $exe['status'],
			]
		);
	}


	// Insert data
	public function insert()
	{
		$ringgit 						= $this->input->post('ringgit');
		$rupiah 						= $this->input->post('rupiah');
		$status 						= $this->input->post('status');

		$exe 							= $this->kurs->insert($ringgit, $rupiah, $status);
		$this->output_json(
			[
				'ringgit' 			=> $ringgit,
				'rupiah' 			=> $rupiah,
				'status' 			=> $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$ringgit 						= $this->input->post('ringgit');
		$rupiah 	 					= $this->input->post('rupiah');
		$status 						= $this->input->post('status');

		$exe 							= $this->kurs->update($id, $ringgit, $rupiah, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'ringgit' 			=> $ringgit,
				'rupiah' 			=> $rupiah,
				'status' 			=> $status,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kurs->delete($id);

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
		$this->load->model('pengaturan/kursModel', 'kurs');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */