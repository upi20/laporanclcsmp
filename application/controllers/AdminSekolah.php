<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminSekolah extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 					= 'Admin Sekolah';
		$this->content 					= 'admin-sekolah';
		$this->navigation 				= ['Admin Sekolah'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Admin Sekolah';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->render();
	}


	// Ajax Data
	public function ajax_data()
	{
		$status = $this->input->post('status');
		$start 	= $this->input->post('start');
		$draw 	= $this->input->post('draw');
		$length = $this->input->post('length');
		$cari 	= $this->input->post('search');
		if(isset($cari['value'])){
			$_cari = $cari['value'];
		}else{
			$_cari = null;
		}
		$data 	= $this->adminSekolah->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->adminSekolah->getAllData(null,null, $_cari, $status)->num_rows();
		
		array($cari);

		echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=> $_cari, 'data'=>$data));
	}

	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->adminSekolah->getDataDetail($id);

		$this->output_json(
			[
				'id' 				=> $exe['id'],
				'id_user' 			=> $exe['id_user'],
				'kode' 				=> $exe['kode'],
				'nama' 				=> $exe['nama'],
				'kota_kab' 			=> $exe['kota_kab'],
				'email' 			=> $exe['user_email'],
				'password' 			=> $exe['user_password'],
				'tanggal' 			=> $exe['tanggal'],
				'status' 			=> $exe['status'],
			]
		);
	}

	// Insert data
	public function insert()
	{
		$kode 							= $this->input->post('kode');
		$nama 							= $this->input->post('nama');
		$kota_kab 						= $this->input->post('kota_kab');
		$email 							= $this->input->post('email');
		$password 						= $this->b_password->create_hash($this->input->post('password'));
		$status 						= $this->input->post('status');
		$cekNama 						= $this->cek($nama);

		if($cekNama->num_rows() > 0)
		{
			$this->output_json(['codeStatus' => 1]);
		}
		else
		{

			$exe 						= $this->adminSekolah->insert($kode, $nama, $kota_kab, $email, $password, $status);

			$this->output_json(
				[
					'codeStatus' 		=> 0,
					'id' 				=> $exe['id'],
					'kode' 				=> $kode,
					'nama' 				=> $nama,
					'kota_kab' 			=> $kota_kab,
					'email' 			=> $email,
					'password' 			=> $password,
					'status' 			=> $status,
				]
			);

		}
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$id_user 						= $this->input->post('id_user');
		$kode 							= $this->input->post('kode');
		$nama 							= $this->input->post('nama');
		$kota_kab 						= $this->input->post('kota_kab');
		$email 							= $this->input->post('email');
		$password 						= $this->b_password->create_hash($this->input->post('password'));
		$status 						= $this->input->post('status');


		$cekNama 						= $this->cek($nama);

		if($cekNama->num_rows() > 0)
		{
			$this->output_json(['codeStatus' => 1]);
		}
		else
		{
			$exe 						= $this->adminSekolah->update($id, $id_user, $kode, $nama, $kota_kab, $email, $password, $status);
			$this->output_json(
				[
					'codeStatus' 		=> 0,
					'id' 				=> $exe['id'],
					'id_user' 			=> $id_user,
					'kode' 				=> $kode,
					'nama' 				=> $nama,
					'kota_kab' 			=> $kota_kab,
					'email' 			=> $email,
					'password' 			=> $password,
					'status' 			=> $status,
				]
			);
		}
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->adminSekolah->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}


	// Change status
	public function changeStatus()
	{
		$id 							= $this->input->post('id');
		$status 						= $this->input->post('status');

		$exe = $this->db->where('id', $id)->update('sekolah', [
			'status' => $status 
		]);

		echo json_encode($exe);
	}

	// Import excel
	public function importExcel()
	{
		require_once APPPATH . '/third_party/PHPExcel-1.8/PHPExcel.php';
		if(isset($_FILES['file']))
		{
			$file 						= $this->gambar->upload([
				'file' => 'file',
				'path' => 'excel',
			]);

			$inputFile = './uploads/excel/' . $file;

			try
			{
				$inputFileType = PHPExcel_IOFactory::identify($inputFile);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFile);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$flag = true;
				$i = 0;


				foreach ($allDataInSheet as $value) 
				{
					if(strtoupper($value['A']) != 'KODE')
					{
						$kode 			= $value['A'];
						$nama 			= $value['B'];
						$kota_kab 		= $value['C'];
						$email 			= $value['D'];
						$password 		= $this->b_password->create_hash($this->input->post('password'));
						$status 		= 1;

						$exe 			= $this->adminSekolah->insert($kode, $nama, $kota_kab, $email, $password, $status);
					}
				}
			}
			catch (Exception $e) 
			{
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
			}
		}

		redirect('adminSekolah','refresh');
	}

	private function cek($nama){
		$cekNama = $this->db->get_where('sekolah', ['nama' => $nama]);
		return $cekNama;
	}

	function __construct()
	{
		parent::__construct();
		$this->load->model('adminSekolahModel', 'adminSekolah');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->library('gambar');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/adminSekolah.php */