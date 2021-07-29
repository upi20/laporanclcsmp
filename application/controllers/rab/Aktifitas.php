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
		$start 	= $this->input->post('start');
		$draw = $this->input->post('draw');
		$draw = $draw == null ? 1 : $draw;
		$length = $this->input->post('length');
		$cari 	= $this->input->post('search');
		$order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];

		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		$data 	= $this->aktifitas->getAllData($draw, $length, $start, $_cari, $order)->result_array();
		$count 	= $this->aktifitas->getAllData(null, null,    null,   $_cari)->num_rows();

		$this->output_json(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->aktifitas->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'id_pengkodeans' 		=> $exe['id_pengkodeans'],
				'kode' 					=> $exe['kode'],
				'uraian' 				=> $exe['uraian'],
				'status' 				=> $exe['status'],
			]
		);
	}

	// get data pengkodeans
	public function getDataPengkodeans()
	{
		# code...

		$get = $this->db->query("select * from aktifitas where id_pengkodeans = 0")->result_array();

		echo json_encode($get);
	}

	// get detail data pengkodeans
	public function getDetailPengkodeans()
	{
		# code...

		$id 							= $this->input->post('id');


		$cek = $this->db->get_where('aktifitas', ['id_pengkodeans' => $id])->num_rows();
		if ($cek > 0) {
			$get_kode_max = $this->db->query("select max(kode) as kode from aktifitas where id_pengkodeans = '" . $id . "'")->row_array();
		} else {
			$get_kode_max = $this->db->query("select max(kode) as kode from aktifitas where id = '" . $id . "'")->row_array();
		}

		echo json_encode($get_kode_max);
	}



	// get data id_pengkodeans
	public function getIdPengkodeans()
	{
		# code...

		$get = $this->db->query("select max(kode) as id from aktifitas where id_pengkodeans = 0")->row_array();
		$id_awal = $get['id'];
		$id_awal = $id_awal + 1;
		$exe['id'] = $id_awal;
		echo json_encode($exe);
	}


	// Insert data
	public function insert()
	{
		$id_pengkodeans 				= $this->input->post('id_pengkodeans');
		$kode 							= $this->input->post('kode');
		$uraian 						= $this->input->post('uraian');
		$status 						= $this->input->post('status');

		$exe 							= $this->aktifitas->insert($id_pengkodeans, $kode, $uraian, $status);
		$this->output_json(
			[
				'id' 	=> $exe
			]
		);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$id_pengkodeans 				= $this->input->post('id_pengkodeans');
		$kode 							= $this->input->post('kode');
		$uraian 						= $this->input->post('uraian');
		$status 						= $this->input->post('status');

		$exe 							= $this->aktifitas->update($id, $id_pengkodeans, $kode, $uraian, $status);

		$this->output_json(
			[
				'id' 				=> $id
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->aktifitas->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('rab/aktifitasModel', 'aktifitas');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */