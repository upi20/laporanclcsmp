<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends Render_Controller
{
	public $id_sekolah = null;
	public $nama_school = null;


	public function index()
	{
		// Page Settings
		$this->title 					= 'Data Siswa';
		$this->content 					= 'siswa';
		$this->navigation 				= ['Data Siswa'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'Data Siswa';
		$this->breadcrumb_2_url 		= '#';

		// Send data to view
		$this->data['sekolah'] = $this->nama_school;
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
		$data 	= $this->siswa->getAllData($length, $start, $_cari, $status, $this->id_sekolah)->result_array();
		$count 	= $this->siswa->getAllData(null,null, $_cari, $status, $this->id_sekolah)->num_rows();
		
		array($cari);

		echo json_encode(array('recordsTotal'=>$count, 'recordsFiltered'=> $count, 'draw'=>$draw, 'search'=> $_cari, 'data'=>$data));
	}

	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->siswa->getDataDetail($id);

		$this->output_json($exe);
	}

	// Insert data
	public function insert()
	{
		$nis 							= $this->input->post('nis');
		$nama 							= $this->input->post('nama');
		$rombel 						= $this->input->post('rombel');
		$grup 							= $this->input->post('grup');
		$email 							= $this->input->post('email');
		$password 						= $this->b_password->create_hash($this->input->post('password'));
		$status 						= $this->input->post('status');

		$exe 							= $this->siswa->insert($nis, $nama, $rombel, $grup, $email, $password, $status, $this->id_sekolah);
		$this->output_json(1);
	}


	// Update data
	public function update()
	{
		$id 							= $this->input->post('id');
		$id_user 						= $this->input->post('id_user');
		$nis 							= $this->input->post('nis');
		$nama 							= $this->input->post('nama');
		$rombel 						= $this->input->post('rombel');
		$grup 							= $this->input->post('grup');
		$email 							= $this->input->post('email');
		$password 						= $this->b_password->create_hash($this->input->post('password'));
		$status 						= $this->input->post('status');

		$exe 							= $this->siswa->update($nis, $id, $id_user, $nama, $rombel, $grup, $email, $password, $status);

		$this->output_json(1);
	}


	// Delete data
	public function delete()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->siswa->delete($id);

		$this->output_json(1);
	}


	// Change status
	public function changeStatus()
	{
		$id 							= $this->input->post('id');
		$status 						= $this->input->post('status');

		$exe = $this->db->where('id', $id)->update('siswa', [
			'status' => $status 
		]);

		echo json_encode($exe);
	}


	// Import Excel
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

				// var_dump($objPHPExcel);
				// var_dump('<br>');
				foreach ($allDataInSheet as $value) 
				{
					if(strtoupper($value['A']) != 'NIS')
					{
						$nis 			= $value['A'];;
						$nama 			= $value['B'];;
						$rombel 		= $value['C'];;
						$grup 			= $value['D'];;
						$email 			= $value['E'];;
						$password 		= $this->b_password->create_hash(123456);
						$status 		= 1;

						$exe 			= $this->siswa->insert($nis, $nama, $rombel, $grup, $email, $password, $status, $this->id_sekolah);
					}
				}
			}
			catch (Exception $e) 
			{
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
			}
		}

		redirect('siswa','refresh');
	}

	

	function __construct()
	{
		parent::__construct();
		$this->load->model('siswaModel', 'siswa');
		$this->default_template = 'templates/dashboard';
		$this->load->library('gambar');
		$this->load->library('plugin');
		$this->load->helper('url');

		$id_sekolah = $this->db->get_where('sekolah', ['id_user' => $this->session->userdata('data')['id']]);
		$this->nama_school = $id_sekolah->row_array()['nama'];
		$this->id_sekolah = $id_sekolah->row_array()['id'];
		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/siswa.php */