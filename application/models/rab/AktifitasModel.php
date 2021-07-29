<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AktifitasModel extends Render_Model
{


	public function getAllData($draw = 1, $show = null, $start = null, $cari = null, $order = null)
	{
		$return  = null;
		$exe 	 = $this->db->select(' a.kode, a.uraian, a.status, b.kode as pengkodean ')
			->from(' aktifitas a ')
			->join(' aktifitas b', 'a.id_pengkodeans = b.id', 'left');

		// order by
		if ($order['order'] != null) {
			$columns = $order['columns'];
			$dir = $order['order'][0]['dir'];
			$order = $order['order'][0]['column'];
			$columns = $columns[$order];
			$order_colum = $columns['data'];

			switch ($order_colum) {
				case 'kode':
					$order_colum = 'b.kode';
					break;
				case 'uraian':
					$order_colum = 'a.uraian';
					break;
				case 'status':
					$order_colum = 'a.status';
					break;
				case 'pengkodean':
					$order_colum = 'a.kode';
					break;
			}

			$this->db->order_by($order_colum, $dir);
		}

		// initial data table
		if ($draw == 1) {
			$this->db->limit(10, 0);
		}

		if ($cari) {
			$exe->where("((a.kode LIKE '%$cari%') or (a.id_pengkodeans LIKE '%$cari%') or (a.status LIKE '%$cari%') or (a.uraian LIKE '%$cari%'))");
		}

		if ($show == null && $start == null) {
			$return = $exe->get();
		} else {
			$exe->limit($show, $start);
			$return = $exe->get();
		}

		return $return;
	}


	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('aktifitas', ['id' => $id]);

		return $exe->row_array();
	}

	public function insert($id_pengkodeans, $kode, $uraian, $status)
	{
		$data['id_pengkodeans'] 	= $id_pengkodeans;
		$data['kode'] 				= $kode;
		$data['uraian'] 			= $uraian;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('aktifitas', $data);
		$exe 						= $this->db->insert_id();

		return $exe;
	}


	public function update($id, $id_pengkodeans, $kode, $uraian, $status)
	{
		$data['id_pengkodeans'] 	= $id_pengkodeans;
		$data['kode'] 				= $kode;
		$data['uraian'] 			= $uraian;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('aktifitas', $data);

		return $exe;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('aktifitas');

		return $exe;
	}
}

/* End of file LevelModel.php */
/* Location: ./application/models/pengaturan/LevelModel.php */