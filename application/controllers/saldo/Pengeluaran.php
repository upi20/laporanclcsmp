<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Pengeluaran';
		$this->content 					= 'saldo-pengeluaran';
		$this->navigation 				= ['pengeluaran'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'pengeluaran';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->render();
	}


	// Ajax Data
	public function ajax_data()
	{
		$id_cabang = $this->input->post('id_cabang');
		$status 	= $this->input->post('status');
		$start 		= $this->input->post('start');
		$draw 		= $this->input->post('draw');
		$length 	= $this->input->post('length');
		$cari 		= $this->input->post('search');
		if(isset($cari['value'])){
			$_cari = $cari['value'];
		}else{
			$_cari = null;
		}
		$data 	= $this->pengeluaran->getAllData($length, $start, $_cari, $status, $id_cabang)->result_array();
		$count 	= $this->pengeluaran->getAllData(null,null, $_cari, $status, $id_cabang)->num_rows();
		
		array($cari);

		echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=> $_cari, 'data'=>$data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->pengeluaran->getDataDetail($id);

		$this->output_json(
			[	
				'id' 					=> $exe['id'],
				'user_nama' 			=> $exe['user_nama'],
				'kode'			 		=> $exe['kode'],
				'nama'					=> $exe['nama'],
				'id_rab' 				=> $exe['id_rab'],
				'keterangan' 			=> $exe['keterangan'],
				'total_ringgit' 		=> $exe['total_ringgit'],
				'total_rupiah'	 		=> $exe['total_rupiah'],
				'status' 				=> $exe['status'],
			]
		);
	}

	// Insert data
	public function insert()
	{
		$id_user 						= $this->input->post('id_user');
		$id_cabang 						= $this->input->post('id_cabang');
		$id_rab 						= $this->input->post('id_rab');
		$keterangan 					= $this->input->post('keterangan');
		$total_ringgit 					= $this->input->post('total_ringgit');
		$total_rupiah 					= $this->input->post('total_rupiah');
		$status 						= $this->input->post('status');

		$exe 							= $this->pengeluaran->insert($id_user, $id_cabang, $id_rab, $keterangan, $total_ringgit, $total_rupiah, $status);
		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'id_user'		 	=> $id_user,
				'id_cabang' 		=> $id_cabang,
				'id_rab' 			=> $id_rab,
				'keterangan' 		=> $keterangan,
				'total_ringgit'		=> $total_ringgit,
				'total_rupiah'		=> $total_rupiah,
				'status' 			=> $status,
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$id_user 						= $this->input->post('id_user');
		$id_cabang 						= $this->input->post('id_cabang');
		$id_rab 						= $this->input->post('id_rab');
		$keterangan 					= $this->input->post('keterangan');
		$total_ringgit 					= $this->input->post('total_ringgit');
		$total_rupiah 					= $this->input->post('total_rupiah');
		$status 						= $this->input->post('status');

		$exe 							= $this->pengeluaran->update($id, $id_user, $id_cabang, $id_rab, $keterangan, $total_ringgit, $total_rupiah, $status);

		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'id_user'		 	=> $id_user,
				'id_cabang' 		=> $id_cabang,
				'id_rab' 			=> $id_rab,
				'keterangan' 		=> $keterangan,
				'total_ringgit'		=> $total_ringgit,
				'total_rupiah'		=> $total_rupiah,
				'updated_date' 		=> $exe['updated_date'],
				'status' 			=> $status,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->pengeluaran->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getCabang(){
		$id 							= $this->input->post('id');

		$exe 							= $this->pengeluaran->getCabang($id);

		$this->output_json($exe);
	}
	

	function __construct()
	{
		parent::__construct();
		$this->load->model('saldo/pengeluaranModel', 'pengeluaran');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/pengeluaran.php */