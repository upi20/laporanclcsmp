<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RabModel extends Render_Model
{


	public function getAllData($show = null, $start = null, $cari = null, $status = null)
	{
		$exe = $this->db->select('*')
			->from('setting_rabs a')
			->where("(a.keterangan LIKE '%" . $cari . "%' or a.status LIKE '%" . $cari . "%' ) ");
		// ->where('a.tanggal_mulai <= ', date('Y-m-d'))
		// ->where('a.tanggal_mulai <= a.tanggal_akhir')
		// ->where('status', 1);

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
		$exe 						= $this->db->get_where('setting_rabs', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($keterangan, $tanggal_mulai, $tanggal_akhir, $status)
	{
		// Auto code config
		// $config['table'] 			= 'kota_kab';
		// $config['field'] 			= 'id';
		// $config['jumlah'] 			= 1;
		// $config['return'] 			= '';


		// Code barang
		// $code 						= $this->_generate($config);

		$data['keterangan'] 			= $keterangan;
		$data['tanggal_mulai'] 			= $tanggal_mulai;
		$data['tanggal_akhir'] 			= $tanggal_akhir;
		$data['status'] 				= $status;
		$data['created_at']				= date('Y-m-d H:i:s');

		$exe 						= $this->db->insert('setting_rabs', $data);
		$exe2['id'] 				= $this->db->insert_id();
		return $exe2;
	}


	public function update($id, $keterangan, $tanggal_mulai, $tanggal_akhir, $status)
	{
		$data['keterangan'] 			= $keterangan;
		$data['tanggal_mulai'] 			= $tanggal_mulai;
		$data['tanggal_akhir'] 			= $tanggal_akhir;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('setting_rabs', $data);
		$detail 					= $this->db->get_where('setting_rabs', ['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		// $exe2['tanggal'] 			= $detail['tanggal'];
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('setting_rabs');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */