<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soal extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Soal';
		$this->content 					= 'soal';
		$this->navigation 				= ['Soal'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Soal';
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
		if(isset($cari['value'])){
			$_cari = $cari['value'];
		}else{
			$_cari = null;
		}
		$data 	= $this->soal->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->soal->getAllData(null,null, $_cari, $status)->num_rows();
		
		array($cari);

		echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=> $_cari, 'data'=>$data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->soal->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'jenis_soal' 			=> $exe['jenis_soal'],
				'id_mata_pelajaran' 	=> $exe['id_mata_pelajaran'],
				'model' 				=> $exe['model'],
				'pengaturan' 			=> $exe['pengaturan'],
				'status' 				=> $exe['status'],
			]
		);
	}


	// Insert data
	public function insert()
	{
		$jenis_soal 					= $this->input->post('jenis_soal');
		$id_mata_pelajaran 				= $this->input->post('id_mata_pelajaran');
		$model 							= $this->input->post('model');
		$pengaturan 					= $this->input->post('pengaturan');
		$status 						= $this->input->post('status');

		$exe 							= $this->soal->insert($jenis_soal, $id_mata_pelajaran, $model, $pengaturan, $status);
		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'token' 			=> $exe['token'],
				'jenis_soal' 		=> $jenis_soal,
				'id_mata_pelajaran' => $id_mata_pelajaran,
				'nama' 				=> $exe['nama'],
				'model' 			=> $model,
				'pengaturan' 		=> $pengaturan,
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
		$jenis_soal 					= $this->input->post('jenis_soal');
		$id_mata_pelajaran 				= $this->input->post('id_mata_pelajaran');
		$model 							= $this->input->post('model');
		$pengaturan 					= $this->input->post('pengaturan');
		$status 						= $this->input->post('status');

		$exe 							= $this->soal->update($id, $jenis_soal, $id_mata_pelajaran, $model, $pengaturan, $status);

		$this->output_json(
			[
				'id' 				=> $id,
				'token' 			=> $exe['token'],
				'jenis_soal' 		=> $jenis_soal,
				'id_mata_pelajaran' => $id_mata_pelajaran,
				'nama' 				=> $exe['nama'],
				'model' 			=> $model,
				'pengaturan' 		=> $pengaturan,
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

		$exe 							= $this->soal->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function preview($id)
	{
		// Page Settings
		$this->title 					= 'Preview Soal';
		$this->content 					= 'preview-soal';
		$this->navigation 				= ['Soal'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Soal';
		$this->breadcrumb_2_url 		= base_url() . 'soal';
		$this->breadcrumb_3 			= 'Preview';
		$this->breadcrumb_3_url 		= '#';
		$this->data['id'] = $id;

		$this->data['records'] 			= $this->db->select('a.*')
		->join('soal b', 'b.id = a.id_soal')
		->join('mata_pelajaran c', 'c.id = b.id_mata_pelajaran')
		->where('a.id_soal', $id)
		->get('soal_detail a')
		->result_array();

		$this->data['pilihan'] 			= function($where) {
			return $this->db->get_where('soal_detail_pilihan_ganda', $where)->result_array();
		};

		$this->render();
	}

	public function getMataPelajaran(){
		$id 							= $this->input->post('id');

		$exe 							= $this->soal->getMataPelajaran($id);

		$this->output_json($exe);
	}
	

	function __construct()
	{
		parent::__construct();
		$this->load->model('soalModel', 'soal');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/soal.php */