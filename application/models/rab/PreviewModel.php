<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PreviewModel extends Render_Model
{


	public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
	{
		$this->db
			->select_sum('a.total_harga_ringgit')
			->select_sum('a.total_harga_rupiah')
			->select('b.kode as npsn, b.nama as nama_cabang, a.status as status');
		$this->db->from(' rabs a');
		$this->db->join(' cabangs b', ' a.id_cabang = b.id ', ' left ');
		$this->db->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ');

		// order by
		if ($order['order'] != null) {
			$columns = $order['columns'];
			$dir = $order['order'][0]['dir'];
			$order = $order['order'][0]['column'];
			$columns = $columns[$order];
			$order_colum = $columns['data'];

			switch ($order_colum) {
				case 'id':
					$order_colum = 'a.id';
				case 'total_harga_ringgit':
					$order_colum = 'a.total_harga_ringgit';
					break;
				case 'total_harga_rupiah':
					$order_colum = 'a.total_harga_rupiah';
					break;
				case 'npsn':
					$order_colum = 'b.kode';
					break;
				case 'nama_cabang':
					$order_colum = 'b.nama';
					break;
				case 'status':
					$order_colum = 'a.status';
					break;
			}

			$this->db->order_by($order_colum, $dir);
		}


		// pencarian
		if ($cari != null) {
			$this->db->where("(
				a.total_harga_ringgit LIKE '%$cari%' or
				a.total_harga_rupiah LIKE '%$cari%' or
				b.kode LIKE '%$cari%' or
				b.nama LIKE '%$cari%' or
				a.status LIKE '%$cari%'
                )");
		}


		// initial data table
		if ($draw == 1) {
			$this->db->limit(10, 0);
		}

		// pagination
		if ($show != null && $start != null) {
			$this->db->limit($show, $start);
		}

		$this->db->group_by('b.kode');

		return $this->db->get();
	}

	public function getAllDataDetail($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $npsn = null)
	{
		$this->db->select(' * ,
		b.kode as npsn,
		b.nama as nama_cabang,
		a.nama as nama_aktifitas,
		a.status as statuss,
		a.kode as kodes');


		$this->db->from(' rabs a');
		$this->db->join(' cabangs b', ' a.id_cabang = b.id ', ' left ');
		$this->db->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ');

		// order by
		if ($order['order'] != null) {
			$columns = $order['columns'];
			$dir = $order['order'][0]['dir'];
			$order = $order['order'][0]['column'];
			$columns = $columns[$order];
			$order_colum = $columns['data'];

			switch ($order_colum) {
				case 'id':
					$order_colum = 'a.id';
				case 'kodes':
					$order_colum = 'a.kode';
					break;
				case 'statuss':
					$order_colum = 'a.status';
					break;
				case 'nama_aktifitas':
					$order_colum = 'a.nama';
					break;
				case 'nama_cabang':
					$order_colum = 'b.nama';
					break;
				case 'npsn':
					$order_colum = 'b.kode';
					break;
			}

			$this->db->order_by($order_colum, $dir);
		}


		// pencarian
		if ($cari != null) {
			$this->db->where("(
				b.kode LIKE '%$cari%' or
				b.nama LIKE '%$cari%' or
				a.nama LIKE '%$cari%' or
				a.status LIKE '%$cari%' or
				a.kode LIKE '%$cari%'
                )");
		}


		// initial data table
		if ($draw == 1) {
			$this->db->limit(10, 0);
		}

		// pagination
		if ($show != null && $start != null) {
			$this->db->limit($show, $start);
		}

		$this->db->where(' b.kode ', $npsn);
		return $this->db->get();
	}

	public function getTotalHarga($npsn)
	{
		$exe 				 = $this->db->select_sum('total_harga_ringgit')
			->select('a.fungsi')
			->from(' rabs a')
			->join(' cabangs b', ' a.id_cabang = b.id ', ' left ')
			->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ')
			->where(' b.kode ', $npsn)
			->get()
			->row_array();
		return $exe;
	}

	public function getTotalHargaRupiah($npsn)
	{
		$exe 				 = $this->db->select_sum('total_harga_rupiah')
			->from(' rabs a')
			->join(' cabangs b', ' a.id_cabang = b.id ', ' left ')
			->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ')
			->where(' b.kode ', $npsn)
			->get()
			->row_array();
		return $exe;
	}

	// admin ubah rab clc ================================================================================================
	public function getIdCabang($npsn)
	{
		$result = $this->db->select("id as id_cabang, nama, user_id")->from("cabangs")->where(['kode' => $npsn])->get()->row_array();
		return isset($result['id_cabang']) ? $result : ['id_cabang' => 0, 'nama' => '', 'user_id' => 0];
	}
	public function ubahGetAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $id_user = null)
	{

		$this->db->select(' * ,
		b.nama as nama_cabang,
		a.nama as nama_aktifitas,
		a.status as statuss,
		a.kode as kodes,
		a.id');
		$this->db->from(' rabs a');
		$this->db->join(' cabangs b', ' a.id_cabang = b.id ', ' left ');
		$this->db->join(' aktifitas c', ' a.id_aktifitas = c.id ', ' left ');
		$this->db->where(['b.user_id' => $id_user]);

		// order by
		if ($order['order'] != null) {
			$columns = $order['columns'];
			$dir = $order['order'][0]['dir'];
			$order = $order['order'][0]['column'];
			$columns = $columns[$order];
			$order_colum = $columns['data'];

			switch ($order_colum) {
				case 'id':
					$order_colum = 'a.id';

				case 'kodes':
					$order_colum = 'a.kode';
					break;
				case 'statuss':
					$order_colum = 'a.status';
					break;
				case 'nama_aktifitas':
					$order_colum = 'a.nama';
					break;
				case 'nama_cabang':
					$order_colum = 'b.nama';
					break;
			}

			$this->db->order_by($order_colum, $dir);
		}

		// pencarian
		if ($cari != null) {
			$this->db->where("(
				a.kode LIKE '%$cari%' or
				b.nama LIKE '%$cari%' or
				a.nama LIKE '%$cari%' or
				a.status LIKE '%$cari%' or
				a.id LIKE '%$cari%'
                )");
		}

		// initial data table
		if ($draw == 1) {
			$this->db->limit(10, 0);
		}

		// pagination
		if ($show != null && $start != null) {
			$this->db->limit($show, $start);
		}
		return $this->db->get();
	}

	public function checkStatus()
	{
		$exe = $this->db->select('*')
			->from('setting_rabs a')
			->where('a.tanggal_mulai <= ', date('Y-m-d'))
			->where('a.tanggal_akhir >= ', date('Y-m-d'))
			->where('a.status', 1)
			->get();
		return $exe;
	}
}

/* End of file LevelModel.php */
/* Location: ./application/models/rab/PreviewModel.php */