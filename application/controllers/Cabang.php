<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Cabang';
		$this->content 					= 'cabang';
		$this->navigation 				= ['Cabang'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Cabang';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->render();
	}


	public function ajax_data()
	{
		$order 	= ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
		$start 	= $this->input->post('start');
		$draw 	= $this->input->post('draw');
		$length = $this->input->post('length');
		$cari 	= $this->input->post('search');
		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		$data 	= $this->cabang->getAllData($length, $start, $_cari, $order, ($this->input->post() == null))->result_array();
		$count 	= $this->cabang->getAllData(null, null, $_cari, $order)->num_rows();

		array($cari);

		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}


	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->cabang->getDataDetail($id);

		$this->output_json(
			[
				'id' 					=> $exe['id'],
				'id_user' 				=> $exe['user_id'],
				'kode' 					=> $exe['kode'],
				'nama' 					=> $exe['nama'],
				'no_telpon' 			=> $exe['no_telpon'],
				'alamat'	 			=> $exe['alamat'],
				'status' 				=> $exe['status'],
				'email' 				=> $exe['user_email'],
				'jumlah_kelas_7' 		=> $exe['jumlah_kelas_7'],
				'jumlah_kelas_8' 		=> $exe['jumlah_kelas_8'],
				'jumlah_kelas_9' 		=> $exe['jumlah_kelas_9'],
				'jumlah_guru_bina' 		=> $exe['jumlah_guru_bina'],
				'jumlah_guru_pamong' 	=> $exe['jumlah_guru_pamong'],
			]
		);
	}


	// Insert data
	public function insert()
	{

		// ceek dulu apakah kode sudah ada di database
		$kode 							= $this->input->post('kode');
		$nama 			 				= $this->input->post('nama');
		$no_telpon						= $this->input->post('no_telpon');
		$alamat 						= $this->input->post('alamat');
		$status 						= $this->input->post('status');
		$email							= $this->input->post('email');
		$jumlah_kelas_7					= $this->input->post('jumlah_kelas_7');
		$jumlah_kelas_8					= $this->input->post('jumlah_kelas_8');
		$jumlah_kelas_9					= $this->input->post('jumlah_kelas_9');
		$jumlah_guru_bina				= $this->input->post('jumlah_guru_bina');
		$jumlah_guru_pamong				= $this->input->post('jumlah_guru_pamong');
		if ($this->db->get_where("cabangs", ['kode' => $kode])->num_rows() == 0) {
			$exe 							= $this->cabang->insert($kode, $nama, $no_telpon, $alamat, $status, $email, $jumlah_kelas_7, $jumlah_kelas_8, $jumlah_kelas_9, $jumlah_guru_bina, $jumlah_guru_pamong);
			$this->output_json(
				[
					// 'id' 				=> $id,
					'kode'			 	=> $kode,
					'nama'		 		=> $nama,
					'no_telepon' 		=> $no_telpon,
					'alamat' 			=> $alamat,
					'status' 			=> $status,
					'email'				=> $email,
					'jumlah_kelas_7'	=> $jumlah_kelas_7,
					'jumlah_kelas_8'	=> $jumlah_kelas_8,
					'jumlah_kelas_9'	=> $jumlah_kelas_9,
					'jumlah_guru_bina'	=> $jumlah_guru_bina,
					'jumlah_guru_pamong' => $jumlah_guru_pamong,
				]
			);
		} else {
			http_response_code(409);
		}
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$id_user						= $this->input->post('id_user');
		$kode 							= $this->input->post('kode');
		$nama 			 				= $this->input->post('nama');
		$no_telpon 						= $this->input->post('no_telpon');
		$alamat 						= $this->input->post('alamat');
		$status 						= $this->input->post('status');
		$email 							= $this->input->post('email');
		$jumlah_kelas_7					= $this->input->post('jumlah_kelas_7');
		$jumlah_kelas_8					= $this->input->post('jumlah_kelas_8');
		$jumlah_kelas_9					= $this->input->post('jumlah_kelas_9');
		$jumlah_guru_bina				= $this->input->post('jumlah_guru_bina');
		$jumlah_guru_pamong				= $this->input->post('jumlah_guru_pamong');
		$exe 							= $this->cabang->update($id, $id_user, $kode, $nama, $no_telpon, $alamat, $status, $email, $jumlah_kelas_7, $jumlah_kelas_8, $jumlah_kelas_9, $jumlah_guru_bina, $jumlah_guru_pamong);

		$this->output_json(
			[
				'id' 				=> $id,
				'kode' 				=> $kode,
				'nama'				=> $nama,
				'no_telpon' 		=> $no_telpon,
				'alamat' 			=> $alamat,
				'status' 			=> $status,
				'email' 			=> $email,
				'jumlah_kelas_7'	=> $jumlah_kelas_7,
				'jumlah_kelas_8'	=> $jumlah_kelas_8,
				'jumlah_kelas_9'	=> $jumlah_kelas_9,
				'jumlah_guru_bina'	=> $jumlah_guru_bina,
				'jumlah_guru_pamong' => $jumlah_guru_pamong,
			]
		);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->cabang->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getMataPelajaran()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->cabang->getMataPelajaran($id);

		$this->output_json($exe);
	}

	public function getKode()
	{
		$this->db->select('RIGHT(cabangs.kode,4) as kode', FALSE);
		$this->db->order_by('kode', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('cabangs');  //cek dulu apakah ada sudah ada kode di tabel.
		if ($query->num_rows() <> 0) {

			$data = $query->row();
			$kode = intval($data->kode) + 1;
		} else {
			$kode = 1;
		}
		$batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
		$kodetampil = "9LN" . $batas;
		$output['id'] = $kodetampil;
		$this->output->set_content_type('js');
		$this->output->set_output(json_encode($output));
	}

	public function resetRab()
	{
		$id = $this->input->post("reset-rab");
		$result = $this->cabang->resetRab($id);
		$this->output_json($result);
	}
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('cabangModel', 'cabang');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/cabang.php */