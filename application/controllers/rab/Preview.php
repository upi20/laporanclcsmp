<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Preview extends Render_Controller
{


	public function index()
	{
		// Page Settings
		$this->title 				= 'RAB Preview';
		if ($this->session->userdata('data')['level'] == 'Super Admin') {
			$this->content 			= 'rab-preview';
		} elseif ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
			$get_cabang 			= $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
			$id_cabang 				= $get_cabang['id'];
			$npsn 					= $get_cabang['kode'];
			$cabang 				= $get_cabang['nama'];

			$get_status				= $this->db->get_where('rabs', ['id_cabang' => $id_cabang])->row_array();
			$this->data['status']	= isset($get_status['status']) ? $get_status['status'] : 4;
			$this->data['npsn']  	= $npsn;
			$this->data['cabang']  	= str_replace('%20', ' ', $cabang);
			$this->data['total']	= $this->preview->getTotalHarga($npsn);
			$checkStatus = $this->preview->checkStatus();
			$this->data['checkStatus'] = $checkStatus->row_array();
			$this->data['statusButton'] = $checkStatus->num_rows();
			$this->content 			= 'rab-preview-sekolah';
		}
		$this->navigation 			= ['RAB', 'Preview'];
		$this->plugins 				= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 		= 'Dashboard';
		$this->breadcrumb_1_url 	= base_url() . 'dashboard';
		$this->breadcrumb_2 		= 'RAB';
		$this->breadcrumb_2_url 	= '#';
		$this->breadcrumb_3 		= 'Preview';
		$this->breadcrumb_3_url 	= '/preview';

		// Send data to view
		$this->render();
	}

	public function detail($npsn = null)
	{

		// Page Settings
		$this->title 					= 'RAB Preview';
		$this->content 					= 'rab-preview-detail';
		$this->navigation 				= ['RAB'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'RAB Preview Detail';
		$this->breadcrumb_2_url 		= '#';
		$getCabang 						= $this->preview->getIdCabang($npsn);
		$this->data['cabang']  			= str_replace('%20', ' ', $getCabang['nama']);
		$get 							= $this->preview->getTotalHarga($npsn);
		$this->data['fungsi']			= $get['fungsi'];
		$this->data['total']			= $get['total_harga_ringgit'];
		$get_id_cabang 					= $this->db->select("id")->from("cabangs")->where("kode", $npsn)->get()->row_array();
		$this->data['id_cabang']		= $get_id_cabang == null ? 0 : $get_id_cabang['id'];
		$get_status				= $this->db->select('a.status, a.fungsi')->join('cabangs b', 'b.id = a.id_cabang')->get_where('rabs a', ['b.kode' => $npsn])->row_array();
		$this->data['npsn']  	= $npsn;
		$this->data['status']	= $get_status['status'];
		// Send data to view
		$this->render();
	}

	public function fungsi($npsn = null, $status = null, $cabang = null)
	{
		$get_cabang = $this->db->get_where('cabangs', ['kode' => $npsn])->row_array();
		$id_cabang  = $get_cabang['id'];

		$upd['fungsi'] = $status;
		$this->db->where('id_cabang', $id_cabang);
		$this->db->update('rabs', $upd);

		if ($status == 1) {
			$fungsi = "Non Aktif";
		} else {
			$fungsi = "Aktif";
		}
		$cabang = str_replace('%20', ' ', $cabang);
		echo "<script>alert('Fungsi ubah data rab berhasil di " . $fungsi . "')</script>";
		redirect('rab/preview/detail/' . $npsn . '/' . $cabang, 'refresh');
	}

	public function tindakan($npsn = null, $status = null, $cabang_nama = null)
	{
		$admin_url = '';
		if ($this->session->userdata('data')['level'] == 'Super Admin') {
			$admin_url = "detail/$npsn/$cabang_nama";
		}

		if ($npsn != null) {
			$get_cabang = $this->db->get_where('cabangs', ['kode' => $npsn])->row_array();
			$id_cabang  = $get_cabang['id'];

			$upd['status'] = $status;
			if ($status == 1) {
				$fungsi = 1;
			} else if ($status == 2) {
				$fungsi = 1;
			} else if ($status == 3) {
				$fungsi = 1;
			} else {
				$fungsi = 0;
			}
			$upd['fungsi'] = $fungsi;
			$exe = $this->db->where('id_cabang', $id_cabang);
			$exe = $this->db->update('rabs', $upd);

			if ($exe) {
				$get_total = $this->preview->getTotalHarga($npsn);
				$get_total2 = $this->preview->getTotalHargaRupiah($npsn);
				if ($status == 2) {
					$saldo['id_cabang'] = $id_cabang;
					$saldo['total_ringgit'] = 0;
					$saldo['total_rupiah'] = 0;
					$saldo['status'] = 'aktif';
					$saldo['created_date'] = date("Y-m-d H:i:s");
					$this->db->insert('saldos', $saldo);
				}
				echo "<script>alert('RAB berhasil diproses')</script>";
				redirect("rab/preview/$admin_url", 'refresh');
			} else {
				echo "<script>alert('Gagal diproses')</script>";
				redirect("rab/preview/$admin_url", 'refresh');
			}
		} else {
			echo "<script>alert('NPSN tidak ada')</script>";
			redirect("rab/preview/$admin_url", 'refresh');
		}
	}

	// Ajax Data
	public function ajax_data()
	{
		$order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
		$start = $this->input->post('start');
		$draw = $this->input->post('draw');
		$draw = $draw == null ? 1 : $draw;
		$length = $this->input->post('length');
		$cari = $this->input->post('search');

		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		// cek filter
		$filter = $this->input->post("filter");

		$data = $this->preview->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
		$count = $this->preview->getAllData(null,    null,   null, $_cari, $order, null)->num_rows();
		$this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
	}

	public function ajax_data_detail()
	{
		$npsn 	= $this->input->post('npsn');
		$order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
		$start = $this->input->post('start');
		$draw = $this->input->post('draw');
		$draw = $draw == null ? 1 : $draw;
		$length = $this->input->post('length');
		$cari = $this->input->post('search');

		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		// cek filter
		$filter = $this->input->post("filter");

		$data = $this->preview->getAllDataDetail($draw, $length, $start, $_cari, $order, $filter, $npsn)->result_array();
		$count = $this->preview->getAllDataDetail(null,    null,   null, $_cari, $order, null, $npsn)->num_rows();
		$this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
	}

	public function excel($npsn)
	{
		$this->load->model('pengaturan/LaporanModel', 'laporan');
		$data['nama_cabang'] = $npsn;
		$data['aktifitas_1'] = $this->db->query("select * from aktifitas WHERE kode = (select a.id_pengkodeans from aktifitas a ,rabs b, cabangs c where b.id_aktifitas = a.id and b.id_cabang = c.id and c.kode = '" . $npsn . "' GROUP BY id_pengkodeans)")->result_array();
		$data['aktifitas_2'] = $this->db->query("select a.uraian,a.id_pengkodeans,a.kode from aktifitas a ,rabs b, cabangs c where b.id_aktifitas = a.id and b.id_cabang = c.id and c.kode = '" . $npsn . "' GROUP BY kode")->result_array();
		$data['isi'] = $this->preview->getAllDataDetail(null, null, null, $npsn)->result_array();
		$data['cabang'] = $this->db->query("select nama from cabangs where kode='$npsn'")->row_array();

		$data['laporan'] = $this->laporan->getData();
		$this->load->view('templates/export/eksport-excel', $data);
	}

	public function ubah($npsn = null)
	{
		$user_id = $this->preview->getIdCabang($npsn);
		$get_status = $this->db->select('a.fungsi, a.status, b.nama, b.id as id_cabang')
			->join('cabangs b', 'b.id = a.id_cabang')
			->get_where('rabs a', ['b.user_id' => $user_id['user_id']])
			->row_array();
		if ($get_status == null) {
			$getCabang = $this->preview->getIdCabang($npsn);
			$get_status = [
				'fungsi' => '0',
				'status' => null,
				'id_cabang' => $getCabang['id_cabang'],
				'nama' => $getCabang['nama'],
			];
		}

		$status = $get_status['status'];
		$cabang = $get_status['nama'];
		if ($status == 0) {
			$status = 'Proses';
		} elseif ($status == 1) {
			$status = 'Ajukan';
		} elseif ($status == 2) {
			$status = 'Terima';
		} elseif ($status == 3) {
			$status = 'Tolak';
		} else {
			$status = '';
		}
		$this->data['fungsi'] = $get_status['fungsi'];
		$this->data['id_cabang'] = $get_status['id_cabang'];
		$this->title 					= "RAB CLC $cabang - (Status: $status)";
		$this->content 					= 'rab-preview-ubah';
		$this->navigation 				= ['RAB', "Preview"];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'RAB';
		$this->breadcrumb_2_url 		= '#';
		$this->breadcrumb_3 			= 'CLC';
		$this->breadcrumb_3_url 		= 'cabang';
		$this->data['id_user']  		= $user_id['user_id'];
		$this->data['npsn']  			= $npsn;
		$this->data['cabang_nama']  	= $cabang;
		$this->data['status']  			= $get_status['fungsi'];
		$this->data['cabang']			= $this->db->get('cabangs')->result_array();
		$this->data['aktifitas']		= $this->db->get_where('aktifitas', ['id_pengkodeans !=' => 0])->result_array();
		$this->data['subaktifitas']		= $this->db->get('rabs')->result_array();

		// Send data to view
		$this->render();
	}

	public function ubah_ajax_data($npsn)
	{
		$user_id = $this->preview->getIdCabang($npsn);
		$order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
		$start = $this->input->post('start');
		$draw = $this->input->post('draw');
		$draw = $draw == null ? 1 : $draw;
		$length = $this->input->post('length');
		$cari = $this->input->post('search');

		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		// cek filter
		$filter = $this->input->post("filter");

		$data = $this->preview->ubahGetAllData($draw, $length, $start, $_cari, $order, $filter, $user_id['user_id'])->result_array();
		$count = $this->preview->ubahGetAllData(null,    null,   null, $_cari, $order, null, $user_id['user_id'])->num_rows();
		$this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('rab/previewModel', 'preview');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */