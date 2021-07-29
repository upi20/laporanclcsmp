<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kota extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Pengaturan - Kota';
		$this->content 					= 'pengaturan-kota';
		$this->navigation 				= ['Kota'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Pengaturan';
		$this->breadcrumb_2_url 		= '#';
		$this->breadcrumb_3 			= 'Kota';
		$this->breadcrumb_3_url 		= base_url() . 'pengaturan/kota';

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
		if(isset($cari['value'])){
			$_cari = $cari['value'];
		}else{
			$_cari = null;
		}
		$data 	= $this->kota->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->kota->getAllData(null,null, $_cari, $status)->num_rows();
		
		array($cari);

		echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=> $_cari, 'data'=>$data));
	}

	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->kota->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'nama' 					=> $exe['nama'],
				'status' 				=> $exe['status'],
			]
		);
	}

	// Insert data
	public function insert()
	{
		$nama 							= $this->input->post('nama');
		$status 						= $this->input->post('status');

		$exe 							= $this->kota->insert($nama, $status);
		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'nama' 				=> $nama,
				'status' 			=> $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$nama 							= $this->input->post('nama');
		$status 						= $this->input->post('status');

		$exe 							= $this->kota->update($id, $nama, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'nama' 				=> $nama,
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
	

	function __construct()
	{
		parent::__construct();
		$this->load->model('pengaturan/kotaModel', 'kota');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */