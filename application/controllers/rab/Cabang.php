<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cabang extends Render_Controller
{
	public function index()
	{
		// Page Settings
		if ($this->session->userdata('data')['level'] == 'Super Admin') {
			$this->title 					= 'RAB CLC';
			$this->content 					= 'rab-cabang';
		} elseif ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
			$get_status = $this->db->select('a.fungsi, a.status, b.nama, b.id as id_cabang')
				->join('cabangs b', 'b.id = a.id_cabang')
				->get_where('rabs a', ['b.user_id' => $this->session->userdata('data')['id']])
				->row_array();
			if ($get_status == null) {
				$getCabang = $this->cabang->getIdCabang();
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
			} elseif ($status == 4) {
				$status = 'Dicairkan';
			} else {
				$status = '';
			}
			$this->data['fungsi'] = $get_status['fungsi'];
			$this->data['id_cabang'] = $get_status['id_cabang'];
			$this->title 					= "RAB CLC $cabang - (Status: $status)";
			$this->content 					= 'rab-cabang-sekolah';
		} else {
			$this->content 					= 'halaman-kosong';
		}
		$this->navigation 				= ['RAB', 'CLC'];
		$this->plugins 					= ['datatables'];

		// Breadcrumb setting
		$this->breadcrumb_1 			= 'Dashboard';
		$this->breadcrumb_1_url 		= base_url() . 'dashboard';
		$this->breadcrumb_2 			= 'RAB';
		$this->breadcrumb_2_url 		= '#';
		$this->breadcrumb_3 			= 'CLC';
		$this->breadcrumb_3_url 		= 'cabang';

		$this->data['cabang']			= $this->db->get('cabangs')->result_array();
		$this->data['aktifitas']		= $this->db->get_where('aktifitas', ['id_pengkodeans !=' => 0])->result_array();
		$this->data['subaktifitas']		= $this->db->get('rabs')->result_array();

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
		if (isset($cari['value'])) {
			$_cari = $cari['value'];
		} else {
			$_cari = null;
		}
		$data 	= $this->cabang->getAllData($length, $start, $_cari, $status)->result_array();
		$count 	= $this->cabang->getAllData(null, null, $_cari, $status)->num_rows();

		array($cari);
		echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
	}

	// Get data detail
	public function getDataDetail()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->cabang->getDataDetail($id);

		$this->output_json($exe);
	}

	// Get data detail
	public function getDataAktifitas()
	{
		$id 							= $this->input->post('id');

		$exe 							= $this->cabang->getDataAktifitas($id);

		$this->output_json($exe);
	}

	// get data sub
	public function getSub()
	{
		# code...

		$id = $this->input->post('id');

		$get = $this->db->query("select max(kode) as id from rabs where id_aktifitas = '" . $id . "'")->row_array();
		$id_awal = $get['id'];
		$id_awal = substr($id_awal, 4);
		// echo json_encode($id_awal);
		if ($id_awal == false) {
			# code...
			$get = $this->db->get_where('aktifitas', ['id' => $id])->row_array();
			$id_akhir = $get['kode'] . '.1';
			$exe['id'] = $get['id'];
			$exe['kode'] = $id_akhir;
			echo json_encode($exe);
		} else {
			$get = $this->db->get_where('aktifitas', ['id' => $id])->row_array();
			$id_akhir = $id_awal + 1;
			$id_akhir = $get['kode'] . '.' . $id_akhir;
			$exe['id'] = $get['id'];
			$exe['kode'] = $id_akhir;
			echo json_encode($exe);
		}
	}

	// get data sub sub
	public function getSubSub()
	{
		# code...

		$id = $this->input->post('id');

		$get = $this->db->query("select * from rabs where id_aktifitas = '" . $id . "'")->result_array();

		echo json_encode($get);
	}

	public function getKurs()
	{
		# code...
		$ringgit = $this->input->post('ringgit');

		$get = $this->db->get('kurs')->row_array();
		$exe['rupiah'] = $ringgit * $get['rupiah'];

		echo json_encode($exe);
	}

	// Insert data
	public function insert()
	{
		$id_cabang		 				= $this->input->post('id_cabang');
		$id_aktifitas					= $this->input->post('id_aktifitas');
		$id_aktifitas_sub				= $this->input->post('id_aktifitas_sub');
		$id_aktifitas_cabang			= $this->input->post('id_aktifitas_cabang');
		$kode_isi_1 					= $this->input->post('kode_isi_1');
		$kode_isi_2 					= $this->input->post('kode_isi_2');
		$kode_isi_3 					= $this->input->post('kode_isi_3');
		$kode 							= $this->input->post('kode');
		$nama 							= $this->input->post('nama');
		$jumlah_1 						= $this->input->post('jumlah_1');
		$satuan_1 						= $this->input->post('satuan_1');
		$jumlah_2 						= $this->input->post('jumlah_2');
		$satuan_2 						= $this->input->post('satuan_2');
		$jumlah_3 						= $this->input->post('jumlah_3');
		$satuan_3 						= $this->input->post('satuan_3');
		$jumlah_4 						= $this->input->post('jumlah_4');
		$satuan_4 						= $this->input->post('satuan_4');
		$harga_ringgit 					= $this->input->post('harga_ringgit');
		$harga_rupiah 					= $this->input->post('harga_rupiah');
		$total_harga_ringgit 			= $this->input->post('total_harga_ringgit');
		$total_harga_rupiah				= $this->input->post('total_harga_rupiah');
		$prioritas 						= $this->input->post('prioritas');

		$get_status = $this->db->query("select status from rabs where id_cabang = '$id_cabang'")->row_array();
		$status 						= $get_status == null ? 0 : $get_status['status'];

		$keterangan 					= $this->input->post('keterangan');
		$exe 							= $this->cabang->insert($id_cabang, $id_aktifitas, $id_aktifitas_sub, $id_aktifitas_cabang, $kode_isi_1, $kode_isi_2, $kode_isi_3, $kode, $nama, $jumlah_1, $satuan_1, $jumlah_2, $satuan_2, $jumlah_3, $satuan_3, $jumlah_4, $satuan_4, $harga_ringgit, $harga_rupiah, $total_harga_ringgit, $total_harga_rupiah, $prioritas, $status, $keterangan);
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
		$id_cabang		 				= $this->input->post('id_cabang');
		$kode 							= $this->input->post('kode');
		$nama 							= $this->input->post('nama');
		$jumlah_1 						= $this->input->post('jumlah_1');
		$satuan_1 						= $this->input->post('satuan_1');
		$jumlah_2 						= $this->input->post('jumlah_2');
		$satuan_2 						= $this->input->post('satuan_2');
		$jumlah_3 						= $this->input->post('jumlah_3');
		$satuan_3 						= $this->input->post('satuan_3');
		$jumlah_4 						= $this->input->post('jumlah_4');
		$satuan_4 						= $this->input->post('satuan_4');
		$harga_ringgit 					= $this->input->post('harga_ringgit');
		$harga_rupiah 					= $this->input->post('harga_rupiah');
		$total_harga_ringgit 			= $this->input->post('total_harga_ringgit');
		$total_harga_rupiah				= $this->input->post('total_harga_rupiah');
		$keterangan 					= $this->input->post('keterangan');

		$exe 							= $this->cabang->update($id, $id_cabang, $kode, $nama, $jumlah_1, $satuan_1, $jumlah_2, $satuan_2, $jumlah_3, $satuan_3, $jumlah_4, $satuan_4, $harga_ringgit, $harga_rupiah, $total_harga_ringgit, $total_harga_rupiah, $keterangan);

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

		$exe 							= $this->cabang->delete($id);

		$this->output_json(
			[
				'id' 			=> $id
			]
		);
	}

	public function getCabang()
	{
		$exe 							= $this->cabang->getCabang();

		$this->output_json($exe);
	}

	public function getAktifitas()
	{
		$exe 							= $this->cabang->getAktifitas();

		$this->output_json($exe);
	}

	public function getAktifitasSub()
	{
		$id_aktifitas 			= $this->input->post('id_aktifitas');
		$exe 					= $this->cabang->getAktifitasSub($id_aktifitas);

		$this->output_json($exe);
	}

	public function getAktifitasCabang()
	{
		$id_aktifitas_sub 		= $this->input->post('id_aktifitas_sub');
		$id_cabang 		        = $this->input->post('id_cabang');
		$id_cabang 				= $id_cabang == null ? $this->id_cabang : $id_cabang;
		$exe 					= $this->cabang->getAktifitasCabang($id_aktifitas_sub, $id_cabang);

		$this->output_json($exe);
	}

	public function getAktifitasCabangKodeIsi1()
	{
		$id_aktifitas_cabang 	= $this->input->post('id_aktifitas_cabang');
		$id_cabang 		        = $this->input->post('id_cabang');
		$id_cabang 				= $id_cabang == null ? $this->id_cabang : $id_cabang;
		$exe 					= $this->cabang->getAktifitasCabangKodeIsi1($id_aktifitas_cabang, $id_cabang);

		$this->output_json($exe);
	}

	public function getAktifitasCabangKodeIsi2()
	{
		$kode_isi_1 			= $this->input->post('kode_isi_1');
		$id_cabang 		        = $this->input->post('id_cabang');
		$id_cabang 				= $id_cabang == null ? $this->id_cabang : $id_cabang;
		$exe 					= $this->cabang->getAktifitasCabangKodeIsi2($kode_isi_1, $id_cabang);

		$this->output_json($exe);
	}

	public function getAktifitasCabangKodeIsi3()
	{
		$kode_isi_2 			= $this->input->post('kode_isi_2');
		$id_cabang 		        = $this->input->post('id_cabang');
		$id_cabang 				= $id_cabang == null ? $this->id_cabang : $id_cabang;
		$exe 					= $this->cabang->getAktifitasCabangKodeIsi3($kode_isi_2, $id_cabang);
		$this->output_json($exe);
	}

	public function getKodeCabang()
	{
		$id_aktifitas_sub 		= $this->input->post('id_aktifitas_sub');
		$id_cabang 		        = $this->input->post('id_cabang');
		$id_cabang 				= $id_cabang == null ? $this->id_cabang : $id_cabang;

		$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id_cabang = '" . $id_cabang . "' and id_aktifitas = '" . $id_aktifitas_sub . "' and kode_isi_1 = 0")->row_array();

		if ($get_kode_max['kode'] == null or $get_kode_max['kode'] == '') {
			$get_kode_max = $this->db->query("select max(kode) as kode from aktifitas where id = '" . $id_aktifitas_sub . "'")->row_array();
			$get_kode_max['kode'] = $get_kode_max['kode'] . ".0";
		}
		$this->output_json($get_kode_max);
	}

	public function getKodeCabangKodeIsi1()
	{
		$id_aktifitas_cabang 		= $this->input->post('id_aktifitas_cabang');
		$id_cabang 					= $this->input->post('id_cabang');
		$id_cabang 					= $id_cabang == null ? $this->id_cabang : $id_cabang;

		$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id_cabang = '" . $id_cabang . "' and kode_isi_1 = '" . $id_aktifitas_cabang . "' and kode_isi_2 = 0")->row_array();

		if ($get_kode_max['kode'] == null or $get_kode_max['kode'] == '') {
			$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id = '" . $id_aktifitas_cabang . "'")->row_array();
			$get_kode_max['kode'] = $get_kode_max['kode'] . ".0";
		}
		$get_kode_max_new = explode('.', $get_kode_max['kode']);
		// jika kode sudah 9
		if (end($get_kode_max_new) == 9) {
			// get kode pre
			$kodePre = $this->kodePre($get_kode_max_new);

			// get kode
			$lastKode = $this->lastMaxKode1($id_cabang, $kodePre);

			// assignemnt to main variable
			$get_kode_max['kode'] = $kodePre . $lastKode;
		}
		$this->output_json($get_kode_max);
	}

	private function lastMaxKode1($id_cabang, $kodePre)
	{
		$cabang = " id_cabang = '$id_cabang' and ";
		$result = $this->db->query("select count(*) as kode from rabs where $cabang ((kode_isi_2 = '0' and kode_isi_3 = '0') and kode LIKE '$kodePre%')")->row_array();
		return $result['kode'];
	}

	public function getKodeCabangKodeIsi2()
	{
		$kode_isi_1 		= $this->input->post('kode_isi_1');
		$id_cabang 			= $this->input->post('id_cabang');
		$id_cabang 			= $id_cabang == null ? $this->id_cabang : $id_cabang;

		$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id_cabang = '" . $id_cabang . "'  and kode_isi_2 = '" . $kode_isi_1 . "' and kode_isi_3 = '0'")->row_array();

		if ($get_kode_max['kode'] == null or $get_kode_max['kode'] == '') {
			$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id = '" . $kode_isi_1 . "'")->row_array();
			$get_kode_max['kode'] = $get_kode_max['kode'] . ".0";
		}
		$get_kode_max_new = explode('.', $get_kode_max['kode']);
		// jika kode sudah 9
		if (end($get_kode_max_new) == 9) {
			// get kode pre
			$kodePre = $this->kodePre($get_kode_max_new);

			// get kode
			$lastKode = $this->lastMaxKode2($id_cabang, $kodePre);

			// assignemnt to main variable
			$get_kode_max['kode'] = $kodePre . $lastKode;
		}

		$this->output_json($get_kode_max);
	}
	private function lastMaxKode2($id_cabang, $kodePre)
	{
		$cabang = " id_cabang = '$id_cabang' and ";
		$result = $this->db->query("select count(*) as kode from rabs where $cabang (kode_isi_3 = '0' and kode LIKE '$kodePre%')")->row_array();
		return $result['kode'];
	}

	public function getKodeCabangKodeIsi3()
	{
		$kode_isi_2 		= $this->input->post('kode_isi_2');
		$id_cabang 			= $this->input->post('id_cabang');
		$id_cabang 			= $id_cabang == null ? $this->id_cabang : $id_cabang;
		$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id_cabang = '" . $id_cabang . "' and kode_isi_3 = '" . $kode_isi_2 . "'")->row_array();

		if ($get_kode_max['kode'] == null or $get_kode_max['kode'] == '') {
			$get_kode_max = $this->db->query("select max(kode) as kode from rabs where id = '" . $kode_isi_2 . "'")->row_array();
			$get_kode_max['kode'] = $get_kode_max['kode'] . ".0";
		}


		$get_kode_max_new = explode('.', $get_kode_max['kode']);

		// jika kode sudah 9
		if (end($get_kode_max_new) == 9) {
			// get kode pre
			$kodePre = $this->kodePre($get_kode_max_new);

			// get kode
			$lastKode = $this->lastMaxKode3($id_cabang, $kodePre);

			// assignemnt to main variable
			$get_kode_max['kode'] = $kodePre . $lastKode;
		}
		$this->output_json($get_kode_max);
	}

	private function lastMaxKode3($id_cabang, $kodePre)
	{
		$cabang = " id_cabang = '$id_cabang' and ";
		$result = $this->db->query("select count(*) as kode from rabs where $cabang kode LIKE '$kodePre%'")->row_array();
		return $result['kode'];
	}

	private function kodePre($kode)
	{
		$result = "";

		for ($i = 0; $i < count($kode) - 1; $i++) {
			$result .=  ($kode[$i] . ".");
		}

		return $result;
	}

	public function cetakExcel($cabang)
	{
		if ($cabang == "all_cabang") {
			# code...

			$status = $this->input->post('status');
			$start 	= $this->input->post('start');
			$draw 	= $this->input->post('draw');
			$length = $this->input->post('length');
			$cari 	= $this->input->post('search');
			if (isset($cari['value'])) {
				$_cari = $cari['value'];
			} else {
				$_cari = null;
			}
			$data['data'] = $this->cabang->getAllData($length, $start, null, $status)->result_array();
			$data['ket'] = $this->cabangdetail;
			$data['level'] = $this->session->userdata('data')['level'];

			$this->load->view("templates/export/export-excel-rab-all-cabang", $data);
		} else {
			# code...

			$status = $this->input->post('status');
			$start 	= $this->input->post('start');
			$draw 	= $this->input->post('draw');
			$length = $this->input->post('length');
			$cari 	= $this->input->post('search');
			if (isset($cari['value'])) {
				$_cari = $cari['value'];
			} else {
				$_cari = null;
			}
			$data['data'] = $this->cabang->getAllData($length, $start, $cabang, $status)->result_array();
			$data['ket'] = $this->cabangdetail = $this->db->get_where('cabangs', ['id' => $cabang])->row_array();
			$this->load->view("templates/export/export-excel-rab-cabang", $data);
		}
	}

	function w($width)
	{
		return 0.71 + $width;
	}

	public function exportFormExcel()
	{
		// footer laporan
		$this->load->model('pengaturan/LaporanModel', 'laporan');
		$laporan = $this->laporan->getData();
		$cabang = $this->input->get('cabang');
		$kurs = $this->db->select("rupiah")->from("kurs")->where("status", "Aktif")->get()->row_array();
		$kurs = $kurs == null ? 0 : $kurs['rupiah'];

		// data utama
		// data sekolah
		$head = $this->db->get_where('cabangs', ['id' => $cabang])->row_array();
		if (!isset($head['id'])) {
			$head = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		}
		// data body
		$detail =  $this->cabang->getAllData(null, null, $cabang, null)->result_array();

		$bulan_array = [
			1 => 'Januari',
			2 => 'February',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];
		$today_m = (int)Date("m");
		$today_d = (int)Date("d");
		$today_y = (int)Date("Y");

		$last_date_of_this_month =  date('t', strtotime(date("Y-m-d")));

		$date = $last_date_of_this_month . " " . $bulan_array[$today_m] . " " . $today_y;

		// laporan baru
		$row = 2;
		$col_start = "A";
		$col_end = "Q";
		$title_excel = "Rencana Anggaran Biaya (RAB) Bantuan Operasional CLC Jenjang Sekolah Menengah Pertama (SMP) " . $head['nama'];
		// Header excel ================================================================================================
		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Dokumen Properti
		$spreadsheet->getProperties()
			->setCreator("SIKK")
			->setLastModifiedBy("SIKK")
			->setTitle($title_excel)
			->setSubject("SIKK")
			->setDescription("
			Rencana Anggaran Biaya (RAB)
			Bantuan Operasional CLC Jenjang Sekolah Menengah Pertama (SMP)
			Tahun $today_y
			")
			->setKeywords("CLC SMP")
			->setCategory("Test result file");

		// initial image ===============================================================================================
		$linux = FCPATH . 'assets/img/kinabalu.jpg';
		$windows = FCPATH . 'assets\img\kinabalu.jpg';
		$linux_cek = file_exists($linux);
		$windows_cek = file_exists($windows);
		$foto = $linux_cek ? $linux : $windows;
		if ($linux_cek || $windows_cek) {
			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
			$drawing->setName('Logo');
			$drawing->setDescription('Logo');

			$drawing->setPath($foto);
			$drawing->setHeight(100);
			$drawing->setOffsetX(20);
			$drawing->setOffsetY(10);
			$drawing->setCoordinates('C1');
		}



		// set default font
		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(11);


		// header ======================================================================================================
		$sheet->mergeCells("D$row:" . $col_end . $row)
			->setCellValue("D$row", 'KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN');
		$sheet->getStyle("D$row:" . $col_end . $row)->getFont()
			->setSize(13);

		$row++;
		$sheet->mergeCells("D$row:" . $col_end . $row)
			->setCellValue("D$row", 'SEKOLAH INDONESIA KOTA KINABALU');
		$sheet->getStyle("D$row:" . $col_end . $row)->applyFromArray([
			'font' => [
				'bold' => true,
				'size' => 13
			]
		]);
		$row++;
		$sheet->mergeCells("D$row:" . $col_end . $row)
			->setCellValue("D$row", "Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park");

		$row++;
		$sheet->mergeCells("D$row:" . $col_end . $row)
			->setCellValue("D$row", "Kota Kinabalu, Sabah Malaysia");

		// set line
		$row++;
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
			"borders" => [
				"bottom" => [
					"borderStyle" => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					"color" => ["rgb" => "000000"],
				],
			],
		]);

		// header 2 ====================================================================================================
		$row += 2;
		$sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
			->setCellValue("A$row", "RENCANA ANGGARAN BIAYA (RAB)");
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
			"font" => [
				"bold" => true,
				"size" => 13
			],
			"alignment" => [
				"horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		]);

		$row++;
		$sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
			->setCellValue("A$row", "BANTUAN OPERASIONAL CLC JENJANG SEKOLAH MENENGAH PERTAMA (SMP)");
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
			"font" => [
				"bold" => true,
				"size" => 13
			],
			"alignment" => [
				"horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		]);

		$row++;
		$sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
			->setCellValue("A$row", "TAHUN " . $today_y);
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
			"font" => [
				"bold" => true,
				"size" => 13
			],
			"alignment" => [
				"horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		]);

		// detail alamat sekolah =======================================================================================
		$row += 3;
		$sheet->setCellValue("B$row", "Nama Sekolah");
		$sheet->setCellValue("C$row", ": " . $head['nama']);

		$row++;
		$sheet->setCellValue("B$row", "Kota");
		$sheet->setCellValue("C$row", ": Kota " . $laporan['kota']);

		$row++;
		$sheet->setCellValue("B$row", "Negara");
		$sheet->setCellValue("C$row", ": Malaysia");

		// Tabel =======================================================================================================
		// Tabel Header
		$row += 2;
		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => [
					'rgb' => '93C5FD',
				]
			],
		];
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray($styleArray);
		$sheet->setCellValue("P" . ($row - 1), "Kurs:");
		$sheet->setCellValue("Q" . ($row - 1), $kurs);
		$cellKurs = "Q" . ($row - 1);
		$row++;
		$styleArray['fill']['startColor']['rgb'] = 'E5E7EB';
		$sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray($styleArray);

		// poin-poin header disini
		$headers = [
			'No',
			'Kode Standar',
			'Sub Standar',
			'Uraian',
			'Jumlah',
			'Satuan',
			'Jumlah',
			'Satuan',
			'Jumlah',
			'Satuan',
			'Jumlah',
			'Satuan',
			'Harga (RM)',
			'Harga (RP)',
			'Jumlah (RM)',
			'Jumlah (RP)',
			'Keterangan',
		];

		// apply header
		for ($i = 0; $i < count($headers); $i++) {
			$sheet->setCellValue(chr(65 + $i) . ($row - 1), $headers[$i]);
			$sheet->setCellValue(chr(65 + $i) . $row, ($i + 1));
		}

		// tabel body
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				],
			],
		];
		$start_tabel = $row + 1;
		$number = 1;
		foreach ($detail as $data) {
			$row++;
			$c = 0;
			$sheet->setCellValue(chr(65 + $c) . $row, $number)
				->setCellValue(chr(65 + ++$c) . $row, $data['uraian'])
				->setCellValue(chr(65 + ++$c) . $row, $data['kodes'])
				->setCellValue(chr(65 + ++$c) . $row, $data['nama_aktifitas'])
				->setCellValue(chr(65 + ++$c) . $row, $data['jumlah_1'])
				->setCellValue(chr(65 + ++$c) . $row, $data['satuan_1'])
				->setCellValue(chr(65 + ++$c) . $row, $data['jumlah_2'])
				->setCellValue(chr(65 + ++$c) . $row, $data['satuan_2'])
				->setCellValue(chr(65 + ++$c) . $row, $data['jumlah_3'])
				->setCellValue(chr(65 + ++$c) . $row, $data['satuan_3'])
				->setCellValue(chr(65 + ++$c) . $row, $data['jumlah_4'])
				->setCellValue(chr(65 + ++$c) . $row, $data['satuan_4'])
				->setCellValue(chr(65 + ++$c) . $row, $data['harga_ringgit'])
				->setCellValue(chr(65 + ++$c) . $row, "=M$row*$cellKurs")
				->setCellValue(chr(65 + ++$c) . $row, '=E' . $row . '*G' . $row . '*I' . $row . '*K' . $row . '*M' . $row)
				->setCellValue(chr(65 + ++$c) . $row, '=E' . $row . '*G' . $row . '*I' . $row . '*K' . $row . '*N' . $row)
				->setCellValue(chr(65 + ++$c) . $row, $data['keterangan']);
			$number++;
		}

		// row jumlah
		// format
		// nomor center
		$sheet->getStyle($col_start . $start_tabel . ":" . $col_start . $row)
			->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// border all data
		$sheet->getStyle($col_start . $start_tabel . ":" . $col_end . $row)
			->applyFromArray($styleArray);

		// $code_rm = '_-[$RM-ms-MY]* #.##0,00_-;-[$RM-ms-MY]* #.##0,00_-;_-[$RM-ms-MY]* "-"??_-;_-@_-';
		// $sheet->getStyle("F" . $start_tabel . ":" . $col_end . $row)->getNumberFormat()->setFormatCode($code_rm);
		$sheet->getStyle("M" . $start_tabel . ":" . "P" . $row)
			->getNumberFormat()
			->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


		// footer
		$row += 3;
		$sheet->setCellValue($col_start . $row, "Mengetahui");
		$sheet->setCellValue($col_end . $row, $laporan['kota'] . ", " . $date);

		$row++;
		$sheet->setCellValue($col_start . $row, "Kepala Sekolah");
		$sheet->setCellValue($col_end . $row, "Pemegang Kas");

		$row += 3;
		$sheet->setCellValue($col_start . $row, $laporan['kepala_nama']);
		$sheet->setCellValue($col_end . $row, $laporan['kas_nama']);

		$row++;
		$sheet->setCellValue($col_start . $row, "NIP. " . $laporan['kepala_nip']);
		$sheet->setCellValue($col_end . $row, "NIP. " . $laporan['kas_nip']);

		// function for width column
		function w($width)
		{
			return 0.71 + $width;
		}


		// set width column
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(w(4));
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(w(40));
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(w(20));
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(w(50));
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(w(13));
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(w(13));
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(w(13));
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(w(13));
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(w(20));

		// add image
		if ($linux_cek || $windows_cek) {
			$drawing->setWorksheet($spreadsheet->getActiveSheet());
		}

		// set  printing area
		$spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea($col_start . '1:' . $col_end . $row);
		$spreadsheet->getActiveSheet()->getPageSetup()
			->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
		$spreadsheet->getActiveSheet()->getPageSetup()
			->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

		// margin
		$spreadsheet->getActiveSheet()->getPageMargins()->setTop(1);
		$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0);
		$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0);
		$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0);

		// page center on
		$spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
		$spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $title_excel . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');

		// baru
	}

	public function importFromExcel()
	{

		$id_cabang = $this->input->post('id_cabang1');
		$fileName = $_FILES['file']['name'];

		$config['upload_path'] = './assets/'; //path upload
		$config['file_name'] = $fileName;  // nama file
		$config['allowed_types'] = 'xls|xlsx'; //tipe file yang diperbolehkan
		$config['max_size'] = 100000; // maksimal sizze

		$this->load->library('upload'); //meload librari upload
		$this->upload->initialize($config);

		$file_location = "";

		if (!$this->upload->do_upload('file')) {
			echo json_encode(['code' => 1, 'message' => $this->upload->display_errors()]);

			exit();
		} else {
			$file_location = array('upload_data' => $this->upload->data());
			$file_location = $file_location['upload_data']['full_path'];
		}


		/** Load $inputFileName to a Spreadsheet Object  **/
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_location);
		$array_from_excel = $spreadsheet->getActiveSheet()->toArray();
		// simpan
		$result = true;
		$start = 1;
		foreach ($array_from_excel as $data) {
			if ($start > 18) {
				# code...

				$kode 							= $data[2];
				$nama 							= $data[3];
				$jumlah_1 						= $data[4];
				$satuan_1 						= $data[5];
				$jumlah_2 						= $data[6];
				$satuan_2 						= $data[7];
				$jumlah_3 						= $data[8];
				$satuan_3 						= $data[9];
				$jumlah_4 						= $data[10];
				$satuan_4 						= $data[11];
				$harga_ringgit 					= str_replace(',', '', $data[12]);
				$harga_rupiah 					= str_replace(',', '', $data[13]);
				$total_harga_ringgit 			= str_replace(',', '', $data[14]);
				$total_harga_rupiah				= str_replace(',', '', $data[15]);
				$prioritas						= "";
				$keterangan 					= $data[16];

				$exe 							= $this->cabang->updateFromExcel($id_cabang, $kode, $nama, $jumlah_1, $satuan_1, $jumlah_2, $satuan_2, $jumlah_3, $satuan_3, $jumlah_4, $satuan_4, $harga_ringgit, $harga_rupiah, $total_harga_ringgit, $total_harga_rupiah, $keterangan, $prioritas);
				if (!$exe) {
					$result = false;
				}
			}
			$start++;
		}

		// hapus file setelah dibaca
		unlink($file_location);
		$this->output_json(
			[
				'code' => $result ? 0 : 1,
				'message' => "File rusak atau tidak lengkap."
			]
		);
	}

	public function getTotalHarga()
	{
		$id = $this->input->post("id");
		$exe = $this->db->select_sum('a.total_harga_ringgit')
			->select('a.fungsi')
			->from(' rabs a')
			->join(' cabangs b', ' a.id_cabang = b.id ', ' left ')
			->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ')
			->where(' b.id ', $id)
			->get()
			->row_array();
		$this->output_json($exe);
	}


	function __construct()
	{
		parent::__construct();
		$this->load->model('rab/CabangModel', 'cabang');
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		$this->cabangdetail = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
		$this->id_cabang 				= $this->cabangdetail['id'];
		// Cek session
		$this->sesion->cek_session();
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */