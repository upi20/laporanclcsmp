<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Render_Controller
{

	public function index()
	{
		// Page Settings
		$this->title = 'Dashboard';
		$this->load->library('libs');
		if ($this->session->userdata('data')['level'] == 'Super Admin') {
			$this->data['pusat'] = $this->dashbrd->getDataPusat();
			$get_cabang = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
			$this->data['profil'] = $get_cabang;
			$this->data['realisasi'] = $this->db->select_sum('harga_ringgit')->select_sum('harga_rupiah')->get_where('realisasis', [])->row_array();
			$this->data['saldo'] = $this->db->select_sum('total_ringgit')->select_sum('total_rupiah')->get_where('saldos', [])->row_array();
			$this->data['rab'] = $this->db->select_sum('total_harga_ringgit')->select_sum('total_harga_rupiah')->get_where('rabs', [])->row_array();
			$this->data['dialihkan'] = $this->db->select_sum('a.jumlah_ringgit')->select_sum('a.jumlah_rupiah')->join('realisasis b', 'b.id = a.id_realisasi')->get_where('pindah_danas a', [])->row_array();
			$this->content = 'dashboard';
		} elseif ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
			$get_cabang = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
			$id_cabang = $get_cabang['id'];
			$this->data['profil'] = $get_cabang;
			$this->data['cabang'] = $this->dashbrd->getDataCabang();
			$this->data['realisasi'] = $this->db->select_sum('harga_ringgit')->select_sum('harga_rupiah')->get_where('realisasis', ['id_cabang' => $id_cabang])->row_array();
			$this->data['saldo'] = $this->db->select_sum('total_ringgit')->select_sum('total_rupiah')->get_where('saldos', ['id_cabang' => $id_cabang])->row_array();
			$this->data['rab'] = $this->db->select_sum('total_harga_ringgit')->select_sum('total_harga_rupiah')->get_where('rabs', ['id_cabang' => $id_cabang])->row_array();
			$this->data['dialihkan'] = $this->db->select_sum('a.jumlah_ringgit')->select_sum('a.jumlah_rupiah')->join('realisasis b', 'b.id = a.id_realisasi')->get_where('pindah_danas a', ['b.id_cabang' => $id_cabang])->row_array();

			// hutang
			$this->data['hutang'] = $this->db->select_sum('a.jumlah')->get_where('hutang a', " (id_cabang = '$id_cabang') and  (status='0') ")->row_array();
			$this->content = 'dashboard-sekolah';
		} else {
			$this->content = 'halaman-kosong';
		}
		$this->navigation = ['Dashboard'];
		$this->plugins = ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 = 'Dashboard';
		$this->breadcrumb_1_url = '#';

		// Send data to view
		$this->render();
	}

	public function profil()
	{
		$this->title = 'Dashboard';
		$this->load->library('libs');
		if ($this->session->userdata('data')['level'] == 'Super Admin') {
			redirect('dashboard');
		} elseif ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
			$get_cabang = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
			$this->data['profil'] = $get_cabang;
			$this->data['cabang'] = $this->dashbrd->getDataCabang();
			$this->data['realisasi'] = $this->db->select_sum('harga_ringgit')->select_sum('harga_rupiah')->get_where('realisasis', ['id_cabang' => $get_cabang['id']])->row_array();
			$this->data['saldo'] = $this->db->select_sum('total_ringgit')->select_sum('total_rupiah')->get_where('saldos', ['id_cabang' => $get_cabang['id']])->row_array();
			$this->data['rab'] = $this->db->select_sum('total_harga_ringgit')->select_sum('total_harga_rupiah')->get_where('rabs', ['id_cabang' => $get_cabang['id']])->row_array();
			$this->data['dialihkan'] = $this->db->select_sum('a.jumlah_ringgit')->select_sum('a.jumlah_rupiah')->join('realisasis b', 'b.id = a.id_realisasi')->get_where('pindah_danas a', ['b.id_cabang' => $get_cabang['id']])->row_array();
			$this->content = 'dashboard-sekolah-profil';
		} else {
			$this->content = 'halaman-kosong';
		}
		$this->navigation = ['Dashboard'];
		$this->plugins = ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 = 'Dashboard';
		$this->breadcrumb_1_url = '#';

		// Send data to view
		$this->render();
	}

	public function tes()
	{
		$this->dashbrd->getDataCabang();
	}

	public function simpan()
	{
		$data = [];
		$id = $this->input->post("id");
		foreach ($this->input->post() as $k => $val) {
			if ($k != 'id') {
				$data[$k] = $val;
			}
		}
		$result = $this->dashbrd->updateDataCabang($id, $data);
		echo json_encode($result);
	}
	function __construct()
	{
		parent::__construct();
		// $this->load->model('master/chemicalModel', 'chemical');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session
		$this->sesion->cek_session();

		// model
		$this->load->model("DashboardModel", 'dashbrd');
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */